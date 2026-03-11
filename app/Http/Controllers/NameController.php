<?php

namespace App\Http\Controllers;

use App\Models\Name;
use App\Models\NameCategory;
use App\Models\NameComment;
use App\Models\NameLike;
use App\Models\Site;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NameController extends Controller
{
    public function search(Request $request): RedirectResponse
    {
        $normalizedGender = $this->normalizeGender($request->query('gender'));
        $query = trim((string) $request->query('q'));
        $siteId = $this->resolveSiteFromRequest($request)?->id;

        $category = NameCategory::query()
            ->forSite($siteId)
            ->where('slug', (string) $request->query('category'))
            ->first();

        $params = array_filter([
            'gender' => $normalizedGender,
            'q' => $query,
        ], fn ($value) => filled($value));

        $this->storeRecentSearch($request, $category, $normalizedGender, $query);

        if ($category) {
            if ($normalizedGender) {
                return redirect()->route('names.category.gender', [
                    'nameCategory' => $category,
                    'genderSlug' => $this->genderToSlug($normalizedGender),
                    'q' => $query,
                ]);
            }

            return redirect()->route('names.category', ['nameCategory' => $category] + $params);
        }

        return redirect()->route('names.archive', $params);
    }

    public function archiveGlobal(Request $request): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        $popularNames = Name::query()
            ->with('nameCategory:id,slug')
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->popular()
            ->limit(10)
            ->get(['id', 'title', 'slug', 'name_category_id', 'likes_count']);

        return $this->resolveThemedView($request, 'names.archive_global', [
            'popularNames' => $popularNames,
        ] + $this->sharedArchiveViewData($siteId));
    }

    public function categoryIndex(string $nameCategory, Request $request): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        $category = NameCategory::query()
            ->forSite($siteId)
            ->where('slug', $nameCategory)
            ->first();

        if (! $category) {
            return app(PageController::class)->show($request, $nameCategory);
        }

        return $this->renderCategoryIndex(
            $category,
            $request,
            $this->normalizeGender($request->query('gender')),
            null,
            $siteId
        );
    }

    public function categoryByGender(NameCategory $nameCategory, string $genderSlug, Request $request): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        $normalizedGender = $this->normalizeGenderFromSlug($genderSlug);
        abort_if($normalizedGender === null, 404);

        return $this->renderCategoryIndex($nameCategory, $request, $normalizedGender, null, $siteId);
    }

    public function categoryByTag(NameCategory $nameCategory, string $tagGroup, string $tag, Request $request): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        return $this->renderCategoryIndex(
            $nameCategory,
            $request,
            $this->normalizeGender($request->query('gender')),
            $tag,
            $siteId
        );
    }

    public function category(NameCategory $nameCategory, string $letter, Request $request): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        $letter = strtoupper($letter);
        abort_unless(preg_match('/^[A-Z]$/', $letter) === 1, 404);

        $namesQuery = $nameCategory->names()
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->when($this->normalizeGender($request->query('gender')), function ($query, $gender) {
                $query->where('gender', $gender);
            })
            ->when(filled($request->query('q')), function ($query) use ($request) {
                $query->where('title', 'like', '%' . trim((string) $request->query('q')) . '%');
            })
            ->orderBy('title');

        $letterNames = (clone $namesQuery)
            ->where('title', 'like', $letter . '%')
            ->get(['id', 'title', 'slug']);

        $allNames = $namesQuery->get(['id', 'title', 'slug']);

        $namesToRender = $letterNames->isNotEmpty() ? $letterNames : $allNames;

        return $this->resolveThemedView($request, 'names.category_letter', [
            'nameCategory' => $nameCategory,
            'letter' => $letter,
            'letters' => range('A', 'Z'),
            'namesToRender' => $namesToRender,
            'activeGender' => $this->normalizeGender($request->query('gender')),
            'activeQuery' => trim((string) $request->query('q')),
        ] + $this->sharedArchiveViewData($siteId));
    }

    public function show(Request $request, NameCategory $nameCategory, Name $name): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        abort_unless($name->name_category_id === $nameCategory->id, 404);
        abort_if($siteId !== null && $name->site_id !== $siteId, 404);

        $approvedComments = $name->comments()
            ->where('is_approved', true)
            ->latest()
            ->get(['id', 'author_name', 'message', 'created_at']);

        return $this->resolveThemedView($request, 'names.show', [
            'name' => $name,
            'nameCategory' => $nameCategory,
            'approvedComments' => $approvedComments,
        ]);
    }

    public function like(Request $request, NameCategory $nameCategory, Name $name): RedirectResponse|JsonResponse
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        abort_unless($name->name_category_id === $nameCategory->id, 404);
        abort_if($siteId !== null && $name->site_id !== $siteId, 404);

        $voterToken = (string) $request->cookie('name_voter_token');
        $shouldSetCookie = blank($voterToken);

        if ($shouldSetCookie) {
            $voterToken = Str::random(64);
        }

        $voterTokenHash = hash('sha256', $voterToken);
        $ip = (string) $request->ip();
        $ipHash = filled($ip)
            ? hash_hmac('sha256', $ip, (string) config('app.key', 'names-like-salt'))
            : null;

        $alreadyLiked = NameLike::query()
            ->where('name_id', $name->id)
            ->where(function ($query) use ($ipHash, $voterTokenHash): void {
                $query->where('voter_token_hash', $voterTokenHash);

                if (filled($ipHash)) {
                    $query->orWhere('ip_hash', $ipHash);
                }
            })
            ->exists();

        $status = 'already_liked';

        if (! $alreadyLiked) {
            NameLike::query()->create([
                'name_id' => $name->id,
                'ip_hash' => $ipHash,
                'voter_token_hash' => $voterTokenHash,
            ]);

            $name->increment('likes_count');
            $status = 'liked';
        }

        if ($request->expectsJson() || $request->ajax()) {
            $response = response()->json([
                'status' => $status,
                'likes_count' => (int) $name->likes_count,
            ]);

            if ($shouldSetCookie) {
                $response->cookie(
                    'name_voter_token',
                    $voterToken,
                    60 * 24 * 365 * 5,
                    null,
                    null,
                    request()->isSecure(),
                    true,
                    false,
                    'Lax'
                );
            }

            return $response;
        }

        $response = redirect()->back()->with('name_like_status', $status);

        if ($shouldSetCookie) {
            $response->cookie(
                'name_voter_token',
                $voterToken,
                60 * 24 * 365 * 5,
                null,
                null,
                request()->isSecure(),
                true,
                false,
                'Lax'
            );
        }

        return $response;
    }

    public function storeComment(Request $request, NameCategory $nameCategory, Name $name): RedirectResponse
    {
        $site = $this->resolveSiteFromRequest($request);
        $siteId = $site?->id;

        abort_unless($name->name_category_id === $nameCategory->id, 404);
        abort_if($siteId !== null && $name->site_id !== $siteId, 404);

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        $ip = (string) $request->ip();
        $ipHash = filled($ip)
            ? hash_hmac('sha256', $ip, (string) config('app.key', 'names-comment-salt'))
            : null;

        $name->comments()->create([
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'message' => $validated['message'],
            'is_approved' => false,
            'approved_at' => null,
            'ip_hash' => $ipHash,
        ]);

        return redirect()
            ->route('names.show', ['nameCategory' => $nameCategory, 'name' => $name])
            ->with('comment_status', 'pending');
    }

    private function normalizeGender(mixed $gender): ?string
    {
        $value = trim((string) $gender);

        return in_array($value, ['male', 'female'], true) ? $value : null;
    }

    private function normalizeGenderFromSlug(string $genderSlug): ?string
    {
        $value = Str::lower(trim($genderSlug));

        return match ($value) {
            'male', 'reu', 'rue', 'mannelijk' => 'male',
            'female', 'teef', 'teefje', 'vrouwelijk' => 'female',
            default => null,
        };
    }

    private function genderToSlug(string $gender): string
    {
        return $gender === 'female' ? 'female' : 'male';
    }

    private function renderCategoryIndex(
        NameCategory $category,
        Request $request,
        ?string $activeGender,
        ?string $tagSlug = null,
        ?int $siteId = null
    ): View
    {
        $activeQuery = trim((string) $request->query('q'));
        $tagCandidates = $this->expandTagCandidates($tagSlug);

        $namesQuery = $category->names()
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->when($activeGender, function ($query, $gender) {
                $query->where('gender', $gender);
            })
            ->when(! empty($tagCandidates), function ($query) use ($tagCandidates) {
                $query->where(function ($tagQuery) use ($tagCandidates): void {
                    foreach ($tagCandidates as $candidate) {
                        $tagQuery->orWhereJsonContains('tags', $candidate);
                    }
                });
            })
            ->when(filled($activeQuery), function ($query) use ($activeQuery) {
                $query->where('title', 'like', '%' . $activeQuery . '%');
            })
            ->orderBy('title');

        $namesToRender = (clone $namesQuery)
            ->orderBy('title')
            ->limit(100)
            ->get(['id', 'title', 'slug']);

        return $this->resolveThemedView($request, 'names.category', [
            'nameCategory' => $category,
            'letter' => 'A',
            'letters' => range('A', 'Z'),
            'namesToRender' => $namesToRender,
            'activeGender' => $activeGender,
            'activeQuery' => $activeQuery,
            'activeTag' => $tagSlug,
        ] + $this->sharedArchiveViewData($siteId));
    }

    private function sharedArchiveViewData(?int $siteId): array
    {
        $categories = NameCategory::query()
            ->forSite($siteId)
            ->withCount([
                'names as names_count' => fn ($query) => $this->applySiteScope($query, $siteId),
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $topMale = Name::query()
            ->with('nameCategory:id,slug')
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->where('gender', 'male')
            ->orderBy('title')
            ->limit(10)
            ->get(['id', 'title', 'slug', 'name_category_id']);

        $topFemale = Name::query()
            ->with('nameCategory:id,slug')
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->where('gender', 'female')
            ->orderBy('title')
            ->limit(10)
            ->get(['id', 'title', 'slug', 'name_category_id']);

        $recentBlogs = Blog::query()
            ->where('status', 'published')
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'thumbnail']);

        return [
            'categories' => $categories,
            'topMale' => $topMale,
            'topFemale' => $topFemale,
            'recentBlogs' => $recentBlogs,
        ];
    }

    private function expandTagCandidates(?string $tagSlug): array
    {
        if (blank($tagSlug)) {
            return [];
        }

        $decoded = trim(urldecode((string) $tagSlug));
        $slug = Str::slug($decoded);
        $spaced = str_replace('-', ' ', $slug);

        return collect([
            $decoded,
            Str::lower($decoded),
            Str::title($decoded),
            $slug,
            $spaced,
            Str::lower($spaced),
            Str::title($spaced),
        ])
            ->filter(fn ($item) => filled($item))
            ->unique()
            ->values()
            ->all();
    }

    private function storeRecentSearch(
        Request $request,
        ?NameCategory $category,
        ?string $gender,
        string $query
    ): void {
        $hasFilters = filled($query) || filled($gender) || $category !== null;
        if (! $hasFilters) {
            return;
        }

        $normalizedQuery = trim($query);

        $signature = md5(json_encode([
            'category' => $category?->slug,
            'gender' => $gender,
            'q' => Str::lower($normalizedQuery),
        ]));

        $entry = [
            'signature' => $signature,
            'category' => $category?->slug,
            'category_name' => $category?->name,
            'gender' => $gender,
            'q' => $normalizedQuery,
            'label' => $this->formatRecentSearchLabel($category, $gender, $normalizedQuery),
        ];

        $recentSearches = collect($request->session()->get('recent_name_searches', []))
            ->reject(fn ($item) => ($item['signature'] ?? null) === $signature)
            ->prepend($entry)
            ->take(6)
            ->values()
            ->all();

        $request->session()->put('recent_name_searches', $recentSearches);
    }

    private function formatRecentSearchLabel(?NameCategory $category, ?string $gender, string $query): string
    {
        $parts = [];

        if (filled($query)) {
            $parts[] = $query;
        }

        if ($category) {
            $parts[] = $category->name;
        }

        if ($gender === 'male') {
            $parts[] = 'Mannelijk';
        }

        if ($gender === 'female') {
            $parts[] = 'Vrouwelijk';
        }

        $label = implode(' - ', $parts);

        return Str::limit($label !== '' ? $label : 'Zoekopdracht', 36);
    }

    private function applySiteScope(\Illuminate\Database\Eloquent\Builder $query, ?int $siteId): \Illuminate\Database\Eloquent\Builder
    {
        return $siteId ? $query->where('site_id', $siteId) : $query;
    }

    private function resolveThemedView(Request $request, string $baseView, array $data): View
    {
        $site = $this->resolveSiteFromRequest($request);
        $theme = Site::resolveTheme($site?->theme);
        $themedView = "themes.{$theme}.{$baseView}";

        return view(view()->exists($themedView) ? $themedView : $baseView, $data + ['site' => $site]);
    }

    private function resolveSiteFromRequest(Request $request): ?Site
    {
        $requestHost = $this->normalizeHost($request->getHost());
        $sites = Site::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'domain', 'theme']);

        $matched = $sites->first(function (Site $site) use ($requestHost): bool {
            $siteHost = $this->normalizeHost($site->domain);

            return $siteHost !== null && $siteHost === $requestHost;
        });

        return $matched ?? $sites->first();
    }

    private function normalizeHost(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $host = Str::lower(trim((string) $value));

        if (! Str::startsWith($host, ['http://', 'https://'])) {
            $host = 'http://' . $host;
        }

        $parsedHost = parse_url($host, PHP_URL_HOST);
        if (! is_string($parsedHost) || $parsedHost === '') {
            return null;
        }

        return Str::startsWith($parsedHost, 'www.')
            ? (string) Str::after($parsedHost, 'www.')
            : $parsedHost;
    }
}
