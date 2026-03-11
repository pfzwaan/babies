<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Babynamengids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/themes/babies.css'])
</head>
<body class="bg-white pt-[130px] text-[#353535] lg:pt-[200px]" style="font-family:Poppins,sans-serif;">
@include('themes.babies.pages.header')

<main>
    @php
        $resolveMedia = static function ($id) {
            return $id ? optional(\Awcodes\Curator\Models\Media::find($id))->url : null;
        };
    @endphp

    <section class="relative overflow-hidden lg:h-[475px]">
        <img src="{{ asset('img/babies/blog-hero-image.svg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover" />
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative container mx-auto flex h-[320px] items-center justify-center md:h-[420px] lg:h-[475px]">
            <h1 class="max-w-[990px] text-center text-[56px] font-bold leading-[58px] text-white md:text-[72px] md:leading-[78px] lg:text-[85px] lg:leading-[80px]" style="font-family:Outfit,sans-serif;">Inspiratie en advies over babynamen</h1>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20 md:px-8">
        <nav class="pt-6 text-[18px] leading-[20px] text-[#353535] md:pt-10 md:text-[22px]">
            <a href="{{ url('/') }}">Home</a> &gt; <span class="font-semibold">Blog</span>
        </nav>

        @if($blogs->isEmpty())
            <p class="mt-10 text-base text-slate-600">Nog geen blogartikelen gepubliceerd.</p>
        @else
            <section class="mt-12">
                <div class="grid gap-y-16 lg:grid-cols-2 lg:gap-x-[68px] lg:gap-y-[113px]">
                    @foreach($blogs->take(2) as $blog)
                        <article>
                            <img src="{{ $resolveMedia($blog->thumbnail) ?: asset('img/babies/blog-card.svg') }}" alt="{{ $blog->title }}" class="h-auto w-full rounded-[30px]" />
                            <div class="mt-[29px]">
                                <h2 class="text-[34px] font-bold leading-[40px] text-[#353535] md:text-[40px] md:leading-[48px]" style="font-family:Outfit,sans-serif;">{{ $blog->title }}</h2>
                                <p class="mt-[31px] text-[18px] font-medium leading-[30px] text-[#353535]">{{ $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 240) }}</p>
                                <p class="mt-[32px] text-[16px] leading-[21px] text-[#656668]">{{ optional($blog->published_at)->format('F d, Y') }}</p>
                                <a href="{{ url('/blog/' . $blog->slug) }}" class="mt-[47px] inline-flex h-[60px] w-[265px] items-center justify-center rounded-full bg-[#63A7E9] text-[18px] font-semibold text-[#353535]">Lees meer</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($blogs->count() > 2)
                    <div class="mt-16 grid gap-y-16 md:grid-cols-2 md:gap-x-10 lg:mt-[113px] lg:grid-cols-3 lg:gap-x-[42px]">
                        @foreach($blogs->slice(2) as $blog)
                            <article>
                                <img src="{{ $resolveMedia($blog->thumbnail) ?: asset('img/babies/blog-card.svg') }}" alt="{{ $blog->title }}" class="h-auto w-full rounded-[30px]" />
                                <div class="mt-[29px]">
                                    <h3 class="text-[34px] font-bold leading-[40px] text-[#353535] md:text-[40px] md:leading-[48px]" style="font-family:Outfit,sans-serif;">{{ $blog->title }}</h3>
                                    <p class="mt-[31px] text-[18px] font-medium leading-[30px] text-[#353535]">{{ $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 180) }}</p>
                                    <p class="mt-[32px] text-[16px] leading-[21px] text-[#656668]">{{ optional($blog->published_at)->format('F d, Y') }}</p>
                                    <a href="{{ url('/blog/' . $blog->slug) }}" class="mt-[47px] inline-flex h-[60px] w-[265px] items-center justify-center rounded-full bg-[#F9E3BF] text-[18px] font-semibold text-[#353535]">Lees meer</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                @if($blogs->hasPages())
                    <nav class="mt-16 flex items-center justify-center gap-[14px] lg:mt-[113px]" aria-label="Pagination">
                        @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                            @if($page <= 3 || $page === $blogs->lastPage() || abs($page - $blogs->currentPage()) <= 1)
                                <a href="{{ $url }}" class="inline-flex h-[73px] w-[73px] items-center justify-center rounded-[10px] {{ $blogs->currentPage() === $page ? 'bg-[#F9E3BF]' : 'border border-[#cecece] bg-white' }} text-[22px] font-semibold leading-[35px] text-[#353535]">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if($blogs->hasMorePages())
                            <a href="{{ $blogs->nextPageUrl() }}" class="inline-flex h-[73px] w-[73px] items-center justify-center rounded-[10px] bg-[#FF7D97] text-white" aria-label="Next page">&rarr;</a>
                        @endif
                    </nav>
                @endif
            </section>
        @endif
    </div>
</main>

@include('themes.babies.pages.footer')
</body>
</html>


