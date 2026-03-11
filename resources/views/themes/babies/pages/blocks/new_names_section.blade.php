@php
    $itemsInput = $data['items'] ?? [];
    $defaults = [
        ['name' => 'Noa', 'category' => 'Jongensnamen'],
        ['name' => 'Liam', 'category' => 'Jongensnamen'],
        ['name' => 'Mila', 'category' => 'Meisjesnamen'],
        ['name' => 'Nora', 'category' => 'Meisjesnamen'],
        ['name' => 'Alex', 'category' => 'Unisex'],
        ['name' => 'Robin', 'category' => 'Unisex'],
        ['name' => 'Luca', 'category' => 'Jongensnamen'],
        ['name' => 'Luna', 'category' => 'Meisjesnamen'],
    ];

    $items = [];
    for ($i = 0; $i < 8; $i++) {
        $items[$i] = array_merge($defaults[$i], $itemsInput[$i] ?? []);
    }

    $male = collect($items)->filter(fn ($item) => str_contains(strtolower((string) $item['category']), 'jongen'))->pluck('name')->take(10)->values()->all();
    $female = collect($items)->filter(fn ($item) => str_contains(strtolower((string) $item['category']), 'meisje'))->pluck('name')->take(10)->values()->all();

    $maleDefaults = ['Noa', 'Liam', 'Luca', 'Sem', 'Levi', 'Milan', 'Finn', 'Adam', 'Daan', 'Noud'];
    $femaleDefaults = ['Mila', 'Nora', 'Emma', 'Olivia', 'Sophie', 'Julia', 'Lotte', 'Sara', 'Yara', 'Luna'];

    $male = array_values(array_unique(array_filter(array_merge($male, $maleDefaults)))) ;
    $female = array_values(array_unique(array_filter(array_merge($female, $femaleDefaults)))) ;

    $male = array_slice($male, 0, 10);
    $female = array_slice($female, 0, 10);

    $renderList = static function (array $names, string $dotAsset) {
        $html = '<ol class="space-y-3 md:space-y-[21px]">';

        foreach (array_values($names) as $idx => $name) {
            $html .= '<li class="flex h-[39px] items-center gap-[11px] text-[23px] font-normal leading-none text-[#000] md:text-[28px]" style="font-family: Onest, sans-serif;">';
            $html .= '<img src="' . e(asset($dotAsset)) . '" alt="" aria-hidden="true" class="h-[39px] w-[39px] shrink-0" />';
            $html .= '<span>' . e((string) $name) . '</span>';
            $html .= '</li>';
        }

        $html .= '</ol>';

        return new \Illuminate\Support\HtmlString($html);
    };
@endphp

<section class="relative mx-auto w-full bg-[#F8E3BF] px-4 py-16 md:px-8 md:py-20">
    <div aria-hidden="true" class="pointer-events-none absolute left-0 right-0 top-0 z-40 h-[22px] -translate-y-full bg-repeat-x" style="background-size: 44px 22px; background-image: radial-gradient(circle at 22px 22px, #F8E3BF 22px, transparent 22px);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute left-0 right-0 bottom-0 z-40 h-[22px] translate-y-full bg-repeat-x" style="background-size: 44px 22px; background-image: radial-gradient(circle at 22px 0, #F8E3BF 22px, transparent 22px);"></div>

    <div class="pointer-events-none absolute inset-0 opacity-25" aria-hidden="true" style="background-image: url('{{ asset('img/babies/hero-ornaments.svg') }}'); background-size: 820px auto; background-position: center; background-repeat: repeat;"></div>

    <div class="relative z-10 container mx-auto grid gap-12 lg:grid-cols-2 lg:gap-x-[68px] lg:gap-y-0">
        <div class="hidden lg:col-span-2 lg:flex lg:justify-center lg:py-1">
            <img
                src="{{ asset('img/babies/top10-smile-cloud.svg') }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none h-[124px] w-[202px]"
            />
        </div>

        <article class="mx-auto w-full max-w-[770px] text-center">
            <h3 class="text-[42px] font-bold leading-[1] text-[#353535] md:text-[55px] md:leading-[60px]" style="font-family: Outfit, sans-serif;">Top 10 Nederlandse jongensnamen</h3>
            <a href="{{ url('/namen') }}" class="mx-auto mt-8 inline-flex h-[60px] w-full max-w-[487px] items-center justify-center gap-3 rounded-full bg-white px-6 text-[16px] font-semibold text-[#353C52] md:text-[18px]" style="font-family: Poppins, sans-serif;">
                <span>Bekijk de complete top 100 jongensnamen</span>
                <svg class="h-3 w-4" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M1 6.5H13.2M13.2 6.5L8.9 2.2M13.2 6.5L8.9 10.8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </article>

        <article class="mx-auto w-full max-w-[770px] text-center">
            <h3 class="text-[42px] font-bold leading-[1] text-[#353535] md:text-[55px] md:leading-[60px]" style="font-family: Outfit, sans-serif;">Top 10 Nederlandse meisjesnamen</h3>
            <a href="{{ url('/namen') }}" class="mx-auto mt-8 inline-flex h-[60px] w-full max-w-[487px] items-center justify-center gap-3 rounded-full bg-white px-6 text-[16px] font-semibold text-[#353C52] md:text-[18px]" style="font-family: Poppins, sans-serif;">
                <span>Bekijk de complete top 100 meisjesnamen</span>
                <svg class="h-3 w-4" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M1 6.5H13.2M13.2 6.5L8.9 2.2M13.2 6.5L8.9 10.8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </article>

        <div class="mx-auto w-full max-w-[770px] rounded-[30px] bg-[#63A7E9] p-4 md:h-[704px] md:p-[29px] lg:mt-6">
            <div class="h-full rounded-[30px] bg-white px-5 py-6 text-left md:px-[44px] md:py-[39px]">
                {!! $renderList($male, 'img/babies/top10-dot.svg') !!}
            </div>
        </div>

        <div class="mx-auto w-full max-w-[770px] rounded-[30px] bg-[#FF7D97] p-4 md:h-[704px] md:p-[29px] lg:mt-6">
            <div class="h-full rounded-[30px] bg-white px-5 py-6 text-left md:px-[44px] md:py-[39px]">
                {!! $renderList($female, 'img/babies/top10-dot-pink.svg') !!}
            </div>
        </div>
    </div>
</section>


