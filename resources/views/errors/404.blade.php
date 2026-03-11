@php
    $resolvedTheme = \App\Models\Site::DEFAULT_THEME;

    try {
        $normalizeHost = function (?string $value): ?string {
            if (blank($value)) {
                return null;
            }

            $host = \Illuminate\Support\Str::lower(trim((string) $value));

            if (! \Illuminate\Support\Str::startsWith($host, ['http://', 'https://'])) {
                $host = 'http://' . $host;
            }

            $parsedHost = parse_url($host, PHP_URL_HOST);

            if (! is_string($parsedHost) || $parsedHost === '') {
                return null;
            }

            return \Illuminate\Support\Str::startsWith($parsedHost, 'www.')
                ? (string) \Illuminate\Support\Str::after($parsedHost, 'www.')
                : $parsedHost;
        };

        $requestHost = $normalizeHost(request()->getHost());

        $sites = \App\Models\Site::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'domain', 'theme']);

        $site = $sites->first(function (\App\Models\Site $item) use ($normalizeHost, $requestHost): bool {
            return $normalizeHost($item->domain) === $requestHost;
        }) ?? $sites->first();

        if ($site) {
            $resolvedTheme = \App\Models\Site::resolveTheme($site->theme);
            $themeClass = $site->theme_class;
        }
    } catch (\Throwable $e) {
        // Keep defaults when site/theme cannot be resolved.
    }
@endphp
@includeFirst(['themes.' . $resolvedTheme . '.errors.404', 'themes.default.errors.404'])
