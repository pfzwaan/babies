<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $blogs = Blog::query()
            ->where('status', 'published')
            ->latest('published_at')
            ->latest('id')
            ->paginate(7)
            ->withQueryString();

        return $this->resolveThemedView($request, 'blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function show(Request $request, string $slug): View
    {
        $blog = Blog::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return $this->resolveThemedView($request, 'blogs.show', [
            'blog' => $blog,
        ]);
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
