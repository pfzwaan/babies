<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @php
        $resolvedTheme = $site?->theme ?? \App\Models\Site::DEFAULT_THEME;
        $themePalette = match ($resolvedTheme) {
            'forest' => [
                'page_bg' => '#f6fbf7',
                'text' => '#1f3a2c',
                'header_bg' => '#ffffff',
                'footer_bg' => '#173527',
                'accent' => '#2f855a',
            ],
            'sunset' => [
                'page_bg' => '#fff8f1',
                'text' => '#4a2b1a',
                'header_bg' => '#ffffff',
                'footer_bg' => '#3a1f1a',
                'accent' => '#e76f51',
            ],
            default => [
                'page_bg' => '#ffffff',
                'text' => '#0f172a',
                'header_bg' => '#ffffff',
                'footer_bg' => '#1e293b',
                'accent' => '#f2613f',
            ],
        };
    @endphp
    <style>
        :root {
            --site-page-bg: {{ $themePalette['page_bg'] }};
            --site-text: {{ $themePalette['text'] }};
            --site-header-bg: {{ $themePalette['header_bg'] }};
            --site-footer-bg: {{ $themePalette['footer_bg'] }};
            --site-accent: {{ $themePalette['accent'] }};
        }
    </style>
    @vite(['resources/css/app.css'])
</head>
<body class="{{ $site?->theme_class ?? 'theme-default' }}" style="background-color: var(--site-page-bg); color: var(--site-text);">
    @include('pages.header')

    <main>
        @if(empty($page->content))
            <h1 class="mb-8 text-3xl font-bold md:text-4xl">{{ $page->title }}</h1>
        @endif

        @foreach(($page->content ?? []) as $block)
            @php($type = \Illuminate\Support\Str::of($block['type'] ?? '')->replaceMatches('/[^a-z0-9_-]/i', '')->value())
            @php($data = $block['data'] ?? [])

            @if($type !== '')
                @includeIf('pages.blocks.' . $type, ['data' => $data, 'block' => $block, 'page' => $page])
            @endif
        @endforeach
    </main>

    @include('pages.footer')
</body>
</html>
