@php
    $title = $data['title'] ?? 'Nieuwe namen toegevoegd in 2026';
    $itemsInput = $data['items'] ?? [];
    $defaults = [
        ['name' => 'Uraia', 'category' => 'Hondennamen'],
        ['name' => 'Vlekje', 'category' => 'Hondennamen'],
        ['name' => 'Femke', 'category' => 'Cavionamen'],
        ['name' => 'Katra', 'category' => 'Vissennamen'],
        ['name' => 'Ash', 'category' => 'Paardennamen'],
        ['name' => 'Cindy', 'category' => 'Kattennamen'],
        ['name' => 'Katra', 'category' => 'Kattennamen'],
        ['name' => 'Femke', 'category' => 'Cavionamen'],
    ];
    $items = [];
    for ($i = 0; $i < 8; $i++) {
        $items[$i] = array_merge($defaults[$i], $itemsInput[$i] ?? []);
    }
    $figmaImage155 = 'https://figma-alpha-api.s3.us-west-2.amazonaws.com/images/431ecb52-7dc7-41b6-ae04-f75adaec8b7d';
    $figmaImage156 = 'https://figma-alpha-api.s3.us-west-2.amazonaws.com/images/c32a01c3-11df-460e-8763-005ad1c8e6d2';
    $figmaImage157 = 'https://figma-alpha-api.s3.us-west-2.amazonaws.com/images/7aafdd86-c0e4-411b-97bd-be131cfb3ff0';
    $figmaImage115 = 'https://figma-alpha-api.s3.us-west-2.amazonaws.com/images/c01221e6-0546-4610-ab55-223fdfae3392';
    $figmaImage119 = 'https://figma-alpha-api.s3.us-west-2.amazonaws.com/images/2abc9b78-220c-4900-a8a6-e967a40fe0c4';
@endphp

<!-- nieuwe namen -->
<section class="relative w-full overflow-hidden bg-[#F0F3FA] py-[72px] md:py-[96px] lg:py-[108px]">
    <img
        src="{{ $figmaImage115 }}"
        class="pointer-events-none absolute top-0 right-0 z-0 h-[230px] w-[446px] select-none"
        alt=""
    >
    <img
        src="{{ $figmaImage119 }}"
        class="pointer-events-none absolute bottom-0 left-0 z-0 h-[230px] w-[446px] select-none"
        alt=""
    >

    <div class="relative z-20 max-w-container mx-auto px-6">
        <h2 class="relative z-20 mb-[36px] text-center font-[Fredoka] font-medium text-[34px] leading-[1.08] text-black md:mb-[48px] md:text-[48px] lg:text-[60px] lg:leading-[65px]">
            {{ $title }}
        </h2>

        <div class="relative z-20 grid grid-cols-1 gap-x-[28px] gap-y-[20px] sm:grid-cols-2 lg:grid-cols-4 lg:gap-y-[33px]">
            @for($i = 0; $i < 8; $i++)
                <article class="flex h-[122px] items-center justify-center rounded-[20px] bg-white text-center shadow-[0_0_30px_rgba(0,0,0,0.10)]">
                    <div class="px-4">
                        <h3 class="font-[Fredoka] font-medium text-[36px] leading-[1] text-[#353C52] md:text-[40px]">
                            {{ $items[$i]['name'] }}
                        </h3>
                        <p class="mt-[8px] font-[Fredoka] font-medium text-[18px] leading-[1] text-[#818590] md:text-[20px]">
                            {{ $items[$i]['category'] }}
                        </p>
                    </div>
                </article>
            @endfor
        </div>

    </div>

    <img
        src="{{ $figmaImage156 }}"
        class="pointer-events-none absolute bottom-0 left-0 z-10 hidden h-[307px] w-[212px] -translate-x-[42%] select-none lg:block"
        alt=""
    >
    <img
        src="{{ $figmaImage155 }}"
        class="pointer-events-none absolute bottom-0 left-[11.5%] z-10 hidden h-[165px] w-[109px] select-none lg:block"
        alt=""
    >
    <img
        src="{{ $figmaImage157 }}"
        class="pointer-events-none absolute bottom-0 right-0 z-10 hidden h-[255px] w-[315px] translate-x-[22%] select-none lg:block"
        alt=""
    >
</section>
