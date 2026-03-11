<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php($resolvedTheme = $site?->resolved_theme ?? \App\Models\Site::DEFAULT_THEME)
    @vite([
        'resources/css/themes/babies.css',
        'resources/css/themes/default.css',
        'resources/css/themes/forest.css',
        'resources/css/themes/sunset.css',
    ])
</head>
<body class="{{ $site?->theme_class ?? 'theme-babies' }} bg-white pt-[130px] font-sans text-[#353535] lg:pt-[200px]" style="font-family: Poppins, sans-serif;">
    @include('themes.' . $resolvedTheme . '.pages.header')

    <main>
        @if(empty($page->content))
            <section class="mx-auto w-full max-w-[1125px] px-4 py-16 md:px-8">
                <h1 class="font-display text-4xl font-bold md:text-5xl" style="font-family: Outfit, sans-serif;">{{ $page->title }}</h1>
            </section>
        @endif

        @foreach(($page->content ?? []) as $block)
            @php($type = \Illuminate\Support\Str::of($block['type'] ?? '')->replaceMatches('/[^a-z0-9_-]/i', '')->value())
            @php($data = $block['data'] ?? [])

            @if($type !== '')
                @includeFirst(
                    ['themes.' . $resolvedTheme . '.pages.blocks.' . $type, 'pages.blocks.' . $type],
                    ['data' => $data, 'block' => $block, 'page' => $page]
                )
            @endif
        @endforeach
    </main>

    @include('themes.' . $resolvedTheme . '.pages.footer')
</body>
</html>
