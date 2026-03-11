@php
    $publishedBlogs = \App\Models\Blog::query()
        ->with('blogCategory:id,name')
        ->where('status', 'published')
        ->latest('published_at')
        ->latest('id')
        ->limit(4)
        ->get(['id', 'title', 'slug', 'blog_category_id', 'thumbnail', 'excerpt', 'content', 'published_at']);

    $cardsInput = $data['cards'] ?? [];

    $cardsDefault = [
        ['image' => null, 'fallback' => 'img/pic2.png', 'title' => 'Hoe kies je de perfecte naam voor je huisdier?', 'excerpt' => 'Het kiezen van de perfecte naam voor je huisdier is een van de eerste beslissingen...', 'button_label' => 'Lees meer', 'url' => '#'],
        ['image' => null, 'fallback' => 'img/pic3.png', 'title' => 'Is een korte of lange naam beter voor een huisdier?', 'excerpt' => 'Korte namen zijn meestal de beste optie voor de meeste huisdieren.', 'button_label' => 'Lees meer', 'url' => '#'],
        ['image' => null, 'fallback' => 'img/pic4.png', 'title' => 'Ideeen en tips ter inspiratie bij het kiezen van een naam', 'excerpt' => 'Weet je niet welke naam je moet kiezen? Er zijn talloze inspiratiebronnen.', 'button_label' => 'Lees meer', 'url' => '#'],
    ];

    $mediaUrl = static function ($id, $fallback) {
        $url = $id ? optional(\Awcodes\Curator\Models\Media::find($id))->url : null;
        return $url ?: asset($fallback);
    };

    $headingHighlight = $data['heading_highlight'] ?? 'Meer dan een naam:';
    $headingText = $data['heading_text'] ?? 'Blog en tips voor het kiezen van de ideale naam';

    $featuredBlog = $publishedBlogs->first();
    $featuredImage = $featuredBlog
        ? $mediaUrl($featuredBlog->thumbnail, 'img/image24.png')
        : $mediaUrl($data['featured_image'] ?? null, 'img/image24.png');
    $featuredTitle = $featuredBlog?->title ?? ($data['featured_title'] ?? 'Veelgemaakte fouten bij het kiezen van een naam voor een hond of kat.');
    $featuredExcerpt = $featuredBlog
        ? ($featuredBlog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $featuredBlog->content), 280))
        : ($data['featured_excerpt'] ?? 'Een van de meest voorkomende fouten bij het kiezen van een huisdiernaam is het kiezen van een naam die te lang of te ingewikkeld is. Dit kan het moeilijk maken voor het huisdier om de naam te leren en er correct op te reageren. Een andere veelgemaakte fout is het constant veranderen van de naam.');
    $featuredButtonLabel = $data['featured_button_label'] ?? 'Lees meer';
    $featuredUrl = $featuredBlog ? url('/blog/' . $featuredBlog->slug) : ($data['featured_url'] ?? '#');
    $featuredTags = $featuredBlog
        ? ('#' . \Illuminate\Support\Str::slug($featuredBlog->blogCategory?->name ?? 'blog'))
        : ($data['featured_tags'] ?? '#fouten bij het kiezen van huisdiernamen #hondennamen #kattennamen');

    $cards = [];
    $dynamicCards = $publishedBlogs->slice(1)->values();
    for ($i = 0; $i < 3; $i++) {
        $blog = $dynamicCards->get($i);
        $cards[$i] = $blog
            ? [
                'image' => $blog->thumbnail,
                'fallback' => $cardsDefault[$i]['fallback'],
                'title' => $blog->title,
                'excerpt' => $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $blog->content), 160),
                'button_label' => $cardsDefault[$i]['button_label'],
                'url' => url('/blog/' . $blog->slug),
            ]
            : array_merge($cardsDefault[$i], $cardsInput[$i] ?? []);
    }

    $ctaLabel = $data['cta_label'] ?? 'Bekijk alle blogposts';
    $ctaUrl = $data['cta_url'] ?? url('/blog');
@endphp

<!--blogs -->
<section class="relative w-full bg-[#2F3A4F] pt-[100px] md:pt-[140px] pb-[100px] md:pb-[140px] -mb-[40px] md:-mb-[60px] z-10">

    <!-- White wave overlay from top -->
    <div class="absolute top-0 left-0 w-full leading-none">
        <svg
            viewBox="0 0 1440 120"
            preserveAspectRatio="none"
            class="w-full h-[60px] md:h-[120px] block"
        >
            <path
                fill="#ffffff"
                d="
                    M0,0
                    L0,50
                    C120,10 240,100 360,80
                    C480,60 600,0 720,30
                    C840,60 960,100 1080,80
                    C1200,60 1320,20 1440,50
                    L1440,0
                    Z
                "
            />
        </svg>
    </div>

    <div class="relative z-10 max-w-container mx-auto px-6">

        <!-- HEADING -->
        <h2 class="text-center font-[Fredoka] font-medium
                   text-[28px] leading-[36px]
                   md:text-[40px] md:leading-[48px]
                   text-white max-w-[1180px] mx-auto">
            <span class="text-[#9ED23A]">{{ $headingHighlight }}</span>
            {{ $headingText }}
        </h2>

        <!-- FEATURED BLOG -->
        <div class="mt-[48px] bg-white rounded-[24px] shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-stretch">

                <div class="w-full md:w-[58%] h-[260px] md:h-auto">
                    <img
                        src="{{ $featuredImage }}"
                        alt="Hond en kat"
                        class="w-full h-full object-cover"
                    />
                </div>

                <div class="w-full md:w-[50%] px-[32px] py-[32px] flex flex-col justify-center bg-white md:rounded-l-[24px] md:-ml-[40px] relative z-10">

                    <h3 class="font-[Fredoka] font-semibold
                               text-[32px] leading-[38px]
                               md:text-[50px] md:leading-[53px]
                               text-[#111827]">
                        {{ $featuredTitle }}
                    </h3>

                    <p class="mt-[16px]
                              text-[18px] leading-[30px]
                              md:text-[20px] md:leading-[35px]
                              text-[#111827] max-w-[770px]">
                        {{ $featuredExcerpt }}
                    </p>

                    <div class="mt-[24px]">
                        <a
                            href="{{ $featuredUrl }}"
                            class="group inline-flex items-center
                                   h-[44px] px-[24px]
                                   rounded-full bg-[#F2643D]
                                   hover:bg-[#E55630]
                                   transition
                                   text-white font-semibold text-[18px]">
                            {{ $featuredButtonLabel }} <span class="arrow-hover ml-1">&rarr;</span>
                        </a>
                    </div>

                    <div class="mt-[12px] text-[16px] leading-[22px] text-[#6B7280]">
                        {{ $featuredTags }}
                    </div>

                </div>
            </div>
        </div>

        <!-- BLOG CARDS -->
        <div class="mt-[40px] grid grid-cols-1 md:grid-cols-3 gap-[24px]">

            <div class="rounded-[20px] shadow-md overflow-hidden flex flex-col">
                <img src="{{ $mediaUrl($cards[0]['image'] ?? null, 'img/pic2.png') }}" class="h-[280px] w-full object-cover" alt="">
                <div class="px-[24px] py-[24px] flex flex-col flex-1 bg-white rounded-t-[24px] -mt-[24px] relative z-10">
                    <h4 class="font-[Fredoka] font-semibold text-[22px] leading-[30px] text-[#111827]">
                        {{ $cards[0]['title'] }}
                    </h4>
                    <p class="mt-[8px] text-[16px] leading-[26px] text-[#111827]">
                        {{ $cards[0]['excerpt'] }}
                    </p>
                    <div class="mt-auto pt-[16px]">
                        <a href="{{ $cards[0]['url'] ?: '#' }}"
                           class="group inline-flex items-center h-[40px] px-[20px]
                                  rounded-full bg-[#F2643D] hover:bg-[#E55630]
                                  text-white text-[16px] font-semibold transition">
                            {{ $cards[0]['button_label'] }} <span class="arrow-hover ml-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-[20px] shadow-md overflow-hidden flex flex-col">
                <img src="{{ $mediaUrl($cards[1]['image'] ?? null, 'img/pic3.png') }}" class="h-[280px] w-full object-cover" alt="">
                <div class="px-[24px] py-[24px] flex flex-col flex-1 bg-white rounded-t-[24px] -mt-[24px] relative z-10">
                    <h4 class="font-[Fredoka] font-semibold text-[22px] leading-[30px] text-[#111827]">
                        {{ $cards[1]['title'] }}
                    </h4>
                    <p class="mt-[8px] text-[16px] leading-[26px] text-[#111827]">
                        {{ $cards[1]['excerpt'] }}
                    </p>
                    <div class="mt-auto pt-[16px]">
                        <a href="{{ $cards[1]['url'] ?: '#' }}"
                           class="group inline-flex items-center h-[40px] px-[20px]
                                  rounded-full bg-[#F2643D] hover:bg-[#E55630]
                                  text-white text-[16px] font-semibold transition">
                            {{ $cards[1]['button_label'] }} <span class="arrow-hover ml-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-[20px] shadow-md overflow-hidden flex flex-col">
                <img src="{{ $mediaUrl($cards[2]['image'] ?? null, 'img/pic4.png') }}" class="h-[280px] w-full object-cover" alt="">
                <div class="px-[24px] py-[24px] flex flex-col flex-1 bg-white rounded-t-[24px] -mt-[24px] relative z-10">
                    <h4 class="font-[Fredoka] font-semibold text-[22px] leading-[30px] text-[#111827]">
                        {{ $cards[2]['title'] }}
                    </h4>
                    <p class="mt-[8px] text-[16px] leading-[26px] text-[#111827]">
                        {{ $cards[2]['excerpt'] }}
                    </p>
                    <div class="mt-auto pt-[16px]">
                        <a href="{{ $cards[2]['url'] ?: '#' }}"
                           class="group inline-flex items-center h-[40px] px-[20px]
                                  rounded-full bg-[#F2643D] hover:bg-[#E55630]
                                  text-white text-[16px] font-semibold transition">
                            {{ $cards[2]['button_label'] }} <span class="arrow-hover ml-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- CTA -->
        <div class="mt-[48px] text-center">
            <a href="{{ $ctaUrl }}"
               class="group inline-flex items-center h-[44px] px-[28px]
                      rounded-full bg-[#F2643D] hover:bg-[#E55630]
                      text-white font-semibold text-[16px] transition">
                {{ $ctaLabel }} <span class="arrow-hover ml-1">&rarr;</span>
            </a>
        </div>

    </div>

    <!-- BOTTOM DOUBLE WAVE -->
    <div class="absolute bottom-0 left-0 w-full leading-none">
        <svg
            viewBox="0 0 1440 120"
            preserveAspectRatio="none"
            class="w-full h-[60px] md:h-[120px]"
        >
            <path
                fill="#ffffff"
                d="
                    M0,40
                    C120,10 240,90 360,70
                    C480,50 600,0 720,30
                    C840,60 960,100 1080,70
                    C1200,40 1320,20 1440,40
                    L1440,120
                    L0,120
                    Z
                "
            />
        </svg>
    </div>

</section>
