<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
    @include('pages.header')

    <main class="max-w-container mx-auto w-full px-6 py-10">
        <article>
            <h1 class="mb-3 text-3xl font-bold md:text-4xl">{{ $blog->title }}</h1>

            @if($blog->published_at)
                <p class="mb-8 text-sm text-slate-500">
                    Gepubliceerd op {{ $blog->published_at->format('d-m-Y H:i') }}
                </p>
            @endif

            <div class="blog-content max-w-none">
                {!! $blog->content !!}
            </div>
        </article>
    </main>

    @include('pages.footer')
</body>
</html>
