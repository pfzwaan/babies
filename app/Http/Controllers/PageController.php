<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(Request $request): View
    {
        return $this->renderPageBySlug($request, 'home');
    }

    public function show(Request $request, string $slug): View
    {
        return $this->renderPageBySlug($request, $slug);
    }

    private function renderPageBySlug(Request $request, string $slug): View
    {
        $site = $this->resolveSiteFromRequest($request);

        $page = Page::query()
            ->when($site, fn ($query) => $query->where('site_id', $site->id))
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $theme = Site::resolveTheme($site?->theme);
        $view = "themes.{$theme}.pages.show";

        if (! view()->exists($view)) {
            $view = 'themes.default.pages.show';
        }

        return view($view, [
            'page' => $page,
            'site' => $site,
        ]);
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
