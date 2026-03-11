<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
    @include('pages.header')

    @include('blogs.sections.page-header')

    <section class="w-full">
        <main class="max-w-container mx-auto w-full px-6 py-10">
            @php
                $featured = $blogs->first();
                $cards = $blogs->slice(1);
                $resolveMedia = static function ($id) {
                    return $id ? optional(\Awcodes\Curator\Models\Media::find($id))->url : null;
                };
            @endphp

            @if($blogs->isEmpty())
                <p class="text-base text-slate-600">Nog geen blogartikelen gepubliceerd.</p>
            @else
                <section class="space-y-10 md:space-y-14">
                    @if($featured)
                        <article class="grid overflow-hidden rounded-[30px] border border-[#DDDDDD] bg-white lg:grid-cols-[minmax(0,792px)_minmax(0,1fr)]">
                            <img
                                src="{{ $resolveMedia($featured->thumbnail) ?: asset('img/figma/26842-251.svg') }}"
                                alt="{{ $featured->title }}"
                                class="h-[300px] w-full object-cover md:h-[420px] lg:h-[672px]"
                            />
                            <div class="px-6 py-7 md:px-10 md:py-12">
                                <div class="space-y-7">
                                    <h1 class="max-w-[771px] font-fredoka text-3xl leading-[1.1] md:text-[50px] md:leading-[53px]">
                                        {{ $featured->title }}
                                    </h1>
                                    <p class="max-w-[771px] text-base leading-8 md:text-[20px] md:leading-[35px]">
                                        {{ $featured->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featured->content), 260) }}
                                    </p>
                                    <a href="{{ url('/blog/' . $featured->slug) }}" class="inline-flex h-[60px] w-[265px] items-center justify-center gap-3 rounded-[100px] bg-accent text-[18px] font-semibold text-white">
                                        <span>Lees meer</span>
                                        <img src="{{ asset('img/figma/26842-267.svg') }}" alt="" aria-hidden="true" class="h-[13px] w-[15px]" />
                                    </a>
                                    <p class="text-[16px] font-medium leading-[15.6px] text-ink">
                                        #{{ \Illuminate\Support\Str::slug($featured->blogCategory?->name ?? 'blog') }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endif

                    <div class="grid gap-8 md:gap-10 lg:grid-cols-2 xl:grid-cols-3">
                        @foreach($cards as $blog)
                            <article class="overflow-hidden rounded-[30px] border border-[#DDDDDD] bg-white shadow-[0_0_60px_rgba(0,0,0,0.15)]">
                                <img src="{{ $resolveMedia($blog->thumbnail) ?: asset('img/figma/26842-251.svg') }}" alt="{{ $blog->title }}" class="h-[340px] w-full object-cover md:h-[464px]" />
                                <div class="space-y-5 px-8 py-8 text-center">
                                    <h2 class="font-fredoka text-[30px] leading-[40px]">{{ $blog->title }}</h2>
                                    <p class="text-[18px] leading-[30px]">{{ $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 180) }}</p>
                                    <a href="{{ url('/blog/' . $blog->slug) }}" class="mx-auto inline-flex h-[60px] w-[265px] items-center justify-center gap-3 rounded-[100px] bg-accent text-[18px] font-semibold text-white">
                                        <span>Lees meer</span>
                                        <img src="{{ asset('img/figma/26842-267.svg') }}" alt="" aria-hidden="true" class="h-[13px] w-[15px]" />
                                    </a>
                                </div>
                                <div class="bg-[#F4F4F4] px-8 py-4 text-center text-[16px] leading-[22px] text-ink">
                                    Trefwoorden: #{{ \Illuminate\Support\Str::slug($blog->blogCategory?->name ?? 'blog') }}
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if($blogs->hasPages())
                        <nav aria-label="Blog pagination" class="flex justify-center pt-2">
                            <ul class="flex flex-wrap items-center justify-center gap-3">
                                @foreach(array_unique(array_filter([1, 2, 3, $blogs->lastPage()], fn ($page) => $page <= $blogs->lastPage())) as $page)
                                    <li>
                                        <a href="{{ $blogs->url($page) }}" class="flex h-[73px] w-[73px] items-center justify-center rounded-[10px] {{ $blogs->currentPage() === $page ? 'bg-ink text-white' : 'border border-[#CECECE] bg-white text-ink' }} font-poppins text-[22px] font-semibold leading-[35px]">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach
                                @if($blogs->hasMorePages())
                                    <li>
                                        <a href="{{ $blogs->nextPageUrl() }}" class="flex h-[73px] w-[73px] items-center justify-center rounded-[10px] bg-accent">
                                            <img src="{{ asset('img/figma/26842-267.svg') }}" alt="Next page" class="h-[15px] w-[26px]" />
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </section>
            @endif
        </main>
    </section>

    @include('pages.footer')
</body>
</html>
