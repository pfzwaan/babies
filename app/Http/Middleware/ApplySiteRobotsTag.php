<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApplySiteRobotsTag
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->is('admin*')) {
            return $response;
        }

        $site = $this->resolveSiteFromRequest($request);
        if ($site && $site->noindex) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        return $response;
    }

    private function resolveSiteFromRequest(Request $request): ?Site
    {
        $columns = ['id', 'domain'];

        if (Schema::hasColumn('sites', 'noindex')) {
            $columns[] = 'noindex';
        }

        $requestHost = $this->normalizeHost($request->getHost());
        $sites = Site::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get($columns);

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
