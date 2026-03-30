<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} - Babynamengids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/themes/babies.css'])
</head>
<body class="bg-white pt-[130px] text-[#353535] lg:pt-[200px]" style="font-family:Poppins,sans-serif;">
@include('themes.babies.pages.header')

<main>
    @php
        $resolveMedia = static function ($id) {
            return $id ? optional(\Awcodes\Curator\Models\Media::find($id))->url : null;
        };

        $recentBlogs = \App\Models\Blog::query()
            ->where('status', 'published')
            ->whereKeyNot($blog->id)
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get(['title', 'slug', 'thumbnail', 'excerpt', 'content', 'published_at']);

        $coverImage = $resolveMedia($blog->thumbnail) ?: asset('img/babies/single-blog-cover.svg');

        $fallbackBlogItems = collect([
            [
                'title' => 'De mooiste korte babynamen',
                'slug' => $blog->slug,
                'image' => asset('img/babies/single-blog-thumb-1.svg'),
                'excerpt' => 'Ontdek korte en krachtige babynamen met een warme, eigentijdse uitstraling.',
                'date' => optional($blog->published_at)->format('F d, Y') ?: now()->format('F d, Y'),
            ],
            [
                'title' => 'Populaire namen van dit moment',
                'slug' => $blog->slug,
                'image' => asset('img/babies/single-blog-thumb-2.svg'),
                'excerpt' => 'Een overzicht van namen die nu opvallen door klank, stijl en populariteit.',
                'date' => optional($blog->published_at)->format('F d, Y') ?: now()->format('F d, Y'),
            ],
            [
                'title' => 'Originele inspiratie voor ouders',
                'slug' => $blog->slug,
                'image' => asset('img/babies/single-blog-thumb-3.svg'),
                'excerpt' => 'Van klassiek tot uniek: inspiratie om een naam te kiezen die echt past.',
                'date' => optional($blog->published_at)->format('F d, Y') ?: now()->format('F d, Y'),
            ],
        ]);

        $blogCards = $recentBlogs->map(function ($item, $index) use ($resolveMedia) {
            return [
                'title' => $item->title,
                'slug' => $item->slug,
                'image' => $resolveMedia($item->thumbnail) ?: asset('img/babies/single-blog-thumb-' . min($index + 1, 3) . '.svg'),
                'excerpt' => $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $item->content), 120),
                'date' => optional($item->published_at)->format('F d, Y'),
            ];
        });

        if ($blogCards->isEmpty()) {
            $blogCards = $fallbackBlogItems;
        }
    @endphp

    <section class="relative overflow-hidden lg:-mt-[30px] lg:h-[475px]">
        <img src="{{ $resolveMedia($blog->thumbnail) ?: asset('img/babies/blog-hero-image.svg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover" />
        <div class="absolute inset-0 bg-black/25"></div>
        <div class="relative container mx-auto flex h-[320px] items-center justify-center px-4 md:h-[420px] lg:h-[475px]">
            <h1 class="max-w-[990px] text-center text-[42px] font-bold leading-[1.04] text-white md:text-[66px] lg:text-[85px]" style="font-family:Outfit,sans-serif;">{{ $blog->title }}</h1>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20 md:px-8">
        <nav class="pt-6 text-[16px] leading-[20px] text-[#6D6D6D] md:pt-8 md:text-[18px]">
            <a href="{{ url('/') }}">Home</a> &gt; <a href="{{ url('/blog') }}">Blog</a> &gt; <span class="font-semibold text-[#353535]">{{ $blog->title }}</span>
        </nav>

        <div class="mt-8 flex flex-col lg:grid lg:gap-8 xl:grid-cols-[minmax(0,1fr)_408px] xl:items-start xl:gap-[28px]">
            <article class="min-w-0">
                <img src="{{ $coverImage }}" alt="{{ $blog->title }}" class="h-auto w-full rounded-[30px] object-cover" />

                <section class="mt-10">
                    <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
                    <h2 class="mt-3 text-[34px] font-bold leading-[1.08] text-[#353535] md:text-[44px] lg:text-[55px]" style="font-family:Outfit,sans-serif;">{{ $blog->title }}</h2>
                    @if($blog->published_at)
                        <p class="mt-5 text-[16px] leading-[21px] text-[#656668]">{{ $blog->published_at->format('F d, Y') }}</p>
                    @endif
                    @if(filled($blog->excerpt))
                        <p class="mt-6 max-w-[980px] text-[18px] leading-[1.85] text-[#4E4B46]">{{ $blog->excerpt }}</p>
                    @endif
                </section>

                <section class="mt-8">
                    <div class="blog-content text-[17px] leading-[1.9] text-[#353535]">{!! $blog->content !!}</div>
                </section>

                @if($blogCards->isNotEmpty())
                    <section class="mt-16">
                        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
                        <h2 class="mt-3 text-[34px] font-bold leading-[1.08] text-[#353535] md:text-[44px] lg:text-[55px]" style="font-family:Outfit,sans-serif;">Gerelateerde blogs</h2>
                        <div class="mt-8 grid gap-6 lg:grid-cols-3">
                            @foreach($blogCards as $related)
                                <article class="overflow-hidden rounded-[26px] border border-[#EEE6DA] bg-white shadow-[0_14px_40px_rgba(38,44,53,0.08)]">
                                    <a href="{{ url('/blog/' . $related['slug']) }}" class="block">
                                        <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" class="h-[215px] w-full object-cover" />
                                    </a>
                                    <div class="p-6">
                                        <a href="{{ url('/blog/' . $related['slug']) }}" class="text-[24px] font-bold leading-[1.15] text-[#353535]" style="font-family:Outfit,sans-serif;">{{ $related['title'] }}</a>
                                        <p class="mt-4 text-[16px] leading-[1.75] text-[#4E4B46]">{{ $related['excerpt'] }}</p>
                                        <p class="mt-5 text-[14px] leading-[20px] text-[#8A8A8A]">{{ $related['date'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </article>

            <aside class="space-y-[52px]">
                <section>
                    <h3 class="text-[30px] font-bold leading-[2] text-[#353535]" style="font-family:Outfit,sans-serif;">Top 10 leukste jongensnamen</h3>
                    <a href="{{ route('names.archive') }}" class="mt-2 inline-flex h-[60px] w-full items-center justify-center gap-3 rounded-full bg-[#F9E3BF] px-6 text-center text-[16px] font-semibold text-[#353B52] lg:text-[17px]">
                        <span>Bekijk de complete top 100 jongensnamen</span>
                        <svg class="h-[13px] w-[15px] shrink-0" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M1 6.44727H14M14 6.44727L8.94737 1.5M14 6.44727L8.94737 11.3946" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="mt-9 rounded-[30px] bg-[#FF7D97] p-[15px]">
                        <div class="rounded-[30px] bg-white px-6 pb-6 pt-7">
                            <ol class="space-y-4">
                                @foreach(\App\Models\Name::query()->where('gender', 'male')->latest('likes_count')->latest('id')->limit(10)->get(['id', 'title', 'slug', 'name_category_id']) as $index => $item)
                                    @if($item->nameCategory)
                                        <li>
                                            <a href="{{ route('names.show', ['nameCategory' => $item->nameCategory, 'name' => $item]) }}" class="flex items-center gap-3 text-[20px] leading-[1.2] text-[#111111] lg:text-[24px]" style="font-family:Onest,sans-serif;">
                                                <span class="inline-flex h-[39px] w-[39px] shrink-0 items-center justify-center rounded-full bg-[rgba(255,125,151,0.31)]">
                                                    <svg class="h-[18px] w-[20px] shrink-0 text-[#FF7D97]" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path d="M4.62732 0.0231372C0.10863 -0.403283 -1.0276 5.16335 0.899619 8.56081C3.25074 12.7045 7.95735 16.4913 12.2226 17.9096C12.3755 17.9606 12.5328 18.0116 12.6902 17.9977C12.913 17.9745 13.101 17.8308 13.2801 17.6918C16.042 15.5133 18.5024 12.7879 19.5469 9.1819C20.3073 6.98955 20.2592 3.84701 18.2402 2.41943C15.5657 0.532986 12.6945 3.4484 11.9036 6.04864C11.5889 4.7184 10.5095 3.77749 9.70102 2.75315C8.59975 1.35802 6.55891 0.213173 4.62732 0.0277732V0.0231372Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <span>{{ $index + 1 }}. {{ $item->title }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </section>

                <section>
                    <h3 class="text-[30px] font-bold leading-[2] text-[#353535]" style="font-family:Outfit,sans-serif;">Top 10 leukste meisjesnamen</h3>
                    <a href="{{ route('names.archive', ['gender' => 'female']) }}" class="mt-2 inline-flex h-[60px] w-full items-center justify-center gap-3 rounded-full bg-[#F9E3BF] px-6 text-center text-[16px] font-semibold text-[#353B52] lg:text-[17px]">
                        <span>Bekijk de complete top 100 meisjesnamen</span>
                        <svg class="h-[13px] w-[15px] shrink-0" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M1 6.44727H14M14 6.44727L8.94737 1.5M14 6.44727L8.94737 11.3946" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="mt-9 rounded-[30px] bg-[#63A7E9] p-[15px]">
                        <div class="rounded-[30px] bg-white px-6 pb-6 pt-7">
                            <ol class="space-y-4">
                                @foreach(\App\Models\Name::query()->where('gender', 'female')->latest('likes_count')->latest('id')->limit(10)->get(['id', 'title', 'slug', 'name_category_id']) as $index => $item)
                                    @if($item->nameCategory)
                                        <li>
                                            <a href="{{ route('names.show', ['nameCategory' => $item->nameCategory, 'name' => $item]) }}" class="flex items-center gap-3 text-[20px] leading-[1.2] text-[#111111] lg:text-[24px]" style="font-family:Onest,sans-serif;">
                                                <span class="inline-flex h-[39px] w-[39px] shrink-0 items-center justify-center rounded-full bg-[rgba(99,167,233,0.31)]">
                                                    <svg class="h-[18px] w-[20px] shrink-0 text-[#63A7E9]" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path d="M4.62732 0.0231372C0.10863 -0.403283 -1.0276 5.16335 0.899619 8.56081C3.25074 12.7045 7.95735 16.4913 12.2226 17.9096C12.3755 17.9606 12.5328 18.0116 12.6902 17.9977C12.913 17.9745 13.101 17.8308 13.2801 17.6918C16.042 15.5133 18.5024 12.7879 19.5469 9.1819C20.3073 6.98955 20.2592 3.84701 18.2402 2.41943C15.5657 0.532986 12.6945 3.4484 11.9036 6.04864C11.5889 4.7184 10.5095 3.77749 9.70102 2.75315C8.59975 1.35802 6.55891 0.213173 4.62732 0.0277732V0.0231372Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <span>{{ $index + 1 }}. {{ $item->title }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </section>

                <section class="rounded-[30px] bg-[#F9E3BF] px-[23px] py-8">
                    <h3 class="text-[28px] font-medium leading-[1.15] text-black lg:text-[30px]" style="font-family:Outfit,sans-serif;">Recente blogberichten</h3>
                    <div class="mt-10 space-y-6">
                        @foreach($blogCards->take(3) as $recent)
                            <article class="flex items-start gap-[11px] {{ ! $loop->last ? 'border-b border-[#E5D3B3] pb-6' : '' }}">
                                <img src="{{ $recent['image'] }}" alt="{{ $recent['title'] }}" class="h-[75px] w-[104px] rounded-[10px] object-cover" />
                                <a href="{{ url('/blog/' . $recent['slug']) }}" class="pt-1 text-[20px] font-bold leading-[1.14] text-[#353535] lg:text-[22px]" style="font-family:Outfit,sans-serif;">{{ $recent['title'] }}</a>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="relative overflow-hidden rounded-[30px] border border-[#E5E5E5] bg-[#F9E3BF] px-[30px] pb-[34px] pt-[60px] text-center">
                    <img src="{{ asset('img/babies/sidebar-banner-bg.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-70" />
                    <div class="relative z-10">
                        <h3 class="mx-auto max-w-[340px] text-[32px] font-semibold leading-[1.15] text-black lg:text-[35px]" style="font-family:Outfit,sans-serif;">Zwangerschapsboxen en babydozen</h3>
                        <p class="mx-auto mt-7 max-w-[270px] text-[25px] leading-[1.33] text-black lg:text-[30px]" style="font-family:Outfit,sans-serif;">Een liefdevol cadeau vanaf het begin.</p>
                        <a href="{{ url('/blog') }}" class="mt-8 inline-flex h-[60px] items-center justify-center gap-3 rounded-full bg-[#FF708A] px-10 text-[18px] font-semibold text-white" style="font-family:Onest,sans-serif;">
                            <span>Ontdek meer</span>
                            <svg class="h-[10px] w-[12px] shrink-0" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 6.44727H14M14 6.44727L8.94737 1.5M14 6.44727L8.94737 11.3946" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <img src="{{ asset('img/babies/sidebar-banner-products.png') }}" alt="Zwangerschapsboxen en babydozen" class="mx-auto mt-0 h-auto w-full max-w-[311px]" />
                    </div>
                </section>
            </aside>
        </div>
    </div>
</main>

@include('themes.babies.pages.footer')
</body>
</html>
