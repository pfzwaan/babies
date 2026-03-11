@php
    $headingHighlight = $data['heading_highlight'] ?? 'Inspiratie';
    $headingText = $data['heading_text'] ?? 'en advies over babynamen';

    $publishedBlogs = \App\Models\Blog::query()
        ->where('status', 'published')
        ->latest('published_at')
        ->latest('id')
        ->limit(5)
        ->get(['title', 'slug', 'thumbnail', 'excerpt', 'content', 'published_at']);

    $cardsInput = $data['cards'] ?? [];

    $cards = [];
    for ($i = 0; $i < 5; $i++) {
        $blog = $publishedBlogs[$i] ?? null;
        $cards[$i] = [
            'image' => $blog?->thumbnail ?? ($cardsInput[$i]['image'] ?? null),
            'title' => $blog?->title ?? ($cardsInput[$i]['title'] ?? 'Blog artikel'),
            'excerpt' => $blog?->excerpt ?: ($blog ? \Illuminate\Support\Str::limit(strip_tags((string) $blog->content), 220) : ($cardsInput[$i]['excerpt'] ?? '')),
            'url' => $blog ? url('/blog/' . $blog->slug) : ($cardsInput[$i]['url'] ?? '#'),
            'date' => $blog?->published_at ? \Illuminate\Support\Carbon::parse($blog->published_at)->translatedFormat('F d, Y') : now()->translatedFormat('F d, Y'),
        ];
    }

    $mediaUrl = static function ($id) {
        return $id ? optional(\Awcodes\Curator\Models\Media::find($id))->url : null;
    };

    $buttonBgByIndex = [
        'bg-[#94C7EB]',
        'bg-[#F8E3BF]',
        'bg-[#94C7EB]',
        'bg-[#94C7EB]',
        'bg-[#F8E3BF]',
    ];

    $renderCard = static function (array $card, int $index, bool $small = false) use ($mediaUrl, $buttonBgByIndex) {
        $titleSize = $small ? 'text-[28px] leading-[1.2]' : 'text-[38px] leading-[1.15]';
        $excerptLimit = $small ? 180 : 300;
        $buttonBg = $buttonBgByIndex[$index] ?? 'bg-[#F8E3BF]';
        $title = \Illuminate\Support\Str::limit((string) $card['title'], $small ? 62 : 80);
        $excerpt = \Illuminate\Support\Str::limit((string) $card['excerpt'], $excerptLimit);
        $imageHeight = $small ? 'h-[260px] md:h-[300px]' : 'h-[280px] md:h-[520px]';

        return new \Illuminate\Support\HtmlString(
            '<article class="space-y-6">' .
                '<img src="' . e($mediaUrl($card['image']) ?: asset('img/babies/blog-card.svg')) . '" alt="' . e($card['title']) . '" class="' . e($imageHeight) . ' w-full rounded-[30px] object-cover" />' .
                '<div class="space-y-5">' .
                    '<p class="text-base leading-none text-[#666A70]" style="font-family: Poppins, sans-serif;">' . e($card['date']) . '</p>' .
                    '<h3 class="' . e($titleSize) . ' font-bold text-[#353535]" style="font-family: Outfit, sans-serif;">' . e($title) . '</h3>' .
                    '<p class="text-lg leading-[1.65] text-[#353535]" style="font-family: Poppins, sans-serif;">' . e($excerpt) . '</p>' .
                    '<a href="' . e($card['url'] ?: '#') . '" class="inline-flex items-center gap-3 rounded-full ' . e($buttonBg) . ' px-8 py-5 text-lg font-semibold leading-none text-[#353535]" style="font-family: Poppins, sans-serif;">' .
                        '<span>Lees meer</span>' .
                        '<svg class="h-3 w-4" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' .
                            '<path d="M1 6.5H13.2M13.2 6.5L8.9 2.2M13.2 6.5L8.9 10.8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>' .
                        '</svg>' .
                    '</a>' .
                '</div>' .
            '</article>'
        );
    };
@endphp

<section class="relative mx-auto w-full max-w-[1720px] overflow-visible px-4 py-16 md:px-8 md:py-24">
    <div class="relative mx-auto mb-12 max-w-[1200px] text-center md:mb-16">
        <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -left-2 -top-10 h-[74px] w-[160px] md:-left-28 md:-top-16 md:h-[103px] md:w-[223px]" />
        <img src="{{ asset('img/babies/hero-star.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -right-1 top-1 h-[54px] w-[58px] md:-right-16 md:top-1/2 md:h-[96px] md:w-[104px] md:-translate-y-1/2" />
        <h2 class="mx-auto max-w-[980px] text-[42px] font-bold leading-[0.95] text-[#353535] md:text-[55px]" style="font-family: Outfit, sans-serif;">
            {{ $headingHighlight }} {{ $headingText }}
        </h2>
    </div>

    <div class="container mx-auto grid gap-10 md:grid-cols-2">
        {!! $renderCard($cards[0], 0, false) !!}
        {!! $renderCard($cards[1], 1, false) !!}
    </div>

    <div class="container mx-auto mt-10 grid gap-10 md:grid-cols-3">
        {!! $renderCard($cards[2], 2, true) !!}
        {!! $renderCard($cards[3], 3, true) !!}
        {!! $renderCard($cards[4], 4, true) !!}
    </div>

    <img src="{{ asset('img/babies/blog-title-sun.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -bottom-8 right-0 h-[110px] w-[108px] md:-bottom-10 md:right-2 md:h-[170px] md:w-[167px]" />
</section>


