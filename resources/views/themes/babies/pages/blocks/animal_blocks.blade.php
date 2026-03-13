@php
    $defaults = [
        ['title' => 'Jongensnamen', 'button_label' => 'Alles bekijken', 'url' => '#'],
        ['title' => 'Meisjesnamen', 'button_label' => 'Alles bekijken', 'url' => '#'],
        ['title' => 'Unisex namen', 'button_label' => 'Alles bekijken', 'url' => '#'],
        ['title' => 'Alle namen', 'button_label' => 'Alles bekijken', 'url' => '#'],
    ];

    $palette = [
        ['bg' => '#E0EEFE', 'border' => '#63A7E9', 'button' => '#63A7E9', 'icon' => asset('img/babies/home-icon-only-jongens.svg')],
        ['bg' => '#FFE9ED', 'border' => '#FF7D97', 'button' => '#FF7D97', 'icon' => asset('img/babies/home-icon-only-meisjes.svg')],
        ['bg' => '#F9E3BF', 'border' => '#EFCC90', 'button' => '#EFCC90', 'icon' => asset('img/babies/home-icon-only-unisex.svg')],
        ['bg' => '#E6F1BE', 'border' => '#B5D44F', 'button' => '#B5D44F', 'icon' => asset('img/babies/home-icon-only-alle.svg')],
    ];

    $cards = [];
    for ($i = 0; $i < 4; $i++) {
        $cards[$i] = array_merge($defaults[$i], data_get($data, 'cards.' . $i, []));
        $url = trim((string) ($cards[$i]['url'] ?? ''));
        $normalizedTitle = \Illuminate\Support\Str::lower(trim((string) ($cards[$i]['title'] ?? '')));

        $cards[$i]['url'] = match ($normalizedTitle) {
            'jongensnamen' => route('names.category', ['nameCategory' => 'jongensnamen']),
            'meisjesnamen' => route('names.category', ['nameCategory' => 'meisjesnamen']),
            default => (($url !== '' && $url !== '#') ? $url : route('names.archive')),
        };

        $cards[$i]['style'] = $palette[$i];
    }
@endphp

<section class="mx-auto w-full max-w-[1598px] px-4 py-14 md:px-8">
    <div class="grid gap-6 xl:grid-cols-4 md:grid-cols-2">
        @foreach($cards as $card)
            <article
                class="rounded-[30px] border-[3px] px-6 pb-7 pt-9 text-center"
                style="background-color: {{ $card['style']['bg'] }}; border-color: {{ $card['style']['border'] }};"
            >
                <div class="relative mx-auto mb-7 h-[140px] w-[185px]">
                    <svg width="185" height="140" viewBox="0 0 185 140" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="absolute left-0 top-0 h-[140px] w-[185px]">
                        <path d="M177.389 40.293C168.359 27.4557 150.748 21.285 137.096 26.6339C128.065 3.95765 95.7292 -4.2637 71.4846 2.06611C43.7254 9.31392 31.3552 36.8023 38.5634 61.2035C30.9527 59.5563 22.6748 60.7668 15.7089 64.7682C1.97467 72.6638 -2.591 89.6988 1.37461 104.328C5.5862 119.863 18.8397 131.89 34.9705 133.848C48.4811 135.488 60.7245 130.657 71.5107 123.358C83.046 141.17 111.193 142.843 131.408 136.935C144.308 133.167 155.948 125.56 163.413 114.326C167.412 108.311 170.815 100.134 170.617 92.5528C188.679 84.672 188.295 55.788 177.393 40.293H177.389Z" fill="white"/>
                    </svg>
                    <img src="{{ $card['style']['icon'] }}" alt="" aria-hidden="true" class="absolute left-1/2 top-1/2 z-[1] h-[56px] w-[92px] -translate-x-1/2 -translate-y-1/2 object-contain" />
                </div>

                <h2 class="mx-auto min-h-[70px] max-w-[275px] text-center text-[35px] font-semibold leading-[34px] text-[#353535]" style="font-family: Outfit, sans-serif;">
                    {{ $card['title'] }}
                </h2>

                <a
                    href="{{ $card['url'] }}"
                    class="mx-auto mt-6 inline-flex h-[60px] w-full max-w-[265px] items-center justify-center gap-3 rounded-full text-[18px] font-medium text-[#353535]"
                    style="background-color: {{ $card['style']['button'] }};"
                >
                    <span>{{ $card['button_label'] }}</span>
                    <svg aria-hidden="true" viewBox="0 0 16 16" class="h-4 w-4" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 8H13.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M9.5 4L13.5 8L9.5 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </article>
        @endforeach
    </div>
</section>
