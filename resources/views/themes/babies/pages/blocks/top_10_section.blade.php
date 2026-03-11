@php
    $title = 'Top 100 babynamen';

    $leftTitle = $data['left_title'] ?? 'Top 100 jongensnamen';
    $rightTitle = $data['right_title'] ?? 'Top 100 meisjesnamen';

    $leftDefaults = ['Noah', 'Luca', 'Levi', 'James', 'Finn', 'Milan', 'Sem', 'Daan', 'Noud', 'Adam'];
    $rightDefaults = ['Emma', 'Olivia', 'Mila', 'Nora', 'Sophie', 'Julia', 'Lotte', 'Sara', 'Yara', 'Luna'];

    $leftInput = $data['left_items'] ?? [];
    $rightInput = $data['right_items'] ?? [];

    $leftItems = [];
    $rightItems = [];

    for ($i = 0; $i < 10; $i++) {
        $leftItems[$i] = $leftInput[$i]['name'] ?? $leftDefaults[$i];
        $rightItems[$i] = $rightInput[$i]['name'] ?? $rightDefaults[$i];
    }
@endphp

<section class="mx-auto w-full max-w-[1125px] px-4 py-12 md:px-8">
    <div class="mb-8 flex items-start gap-4">
        <img src="{{ asset('img/babies/decor-star.svg') }}" alt="" aria-hidden="true" class="mt-2 h-10 w-10" />
        <h2 class="text-4xl font-bold leading-tight text-[#2f2f2f] max-[575px]:text-[34px] md:text-5xl" style="font-family: Outfit, sans-serif;">{{ $title }}</h2>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <article class="rounded-[20px] border-2 border-[#FF7D97] bg-white p-6">
            <h3 class="text-[22px] font-bold leading-[30px] text-[#353535]" style="font-family: Outfit, sans-serif;">{{ $leftTitle }}</h3>
            <ol class="mt-5 space-y-3">
                @foreach($leftItems as $item)
                    <li class="flex items-center gap-3 text-[17px] text-[#353535]">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#FFE9ED] text-sm font-semibold text-[#FF7D97]">{{ $loop->iteration }}</span>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ol>
        </article>

        <article class="rounded-[20px] border-2 border-[#63A7E9] bg-white p-6">
            <h3 class="text-[22px] font-bold leading-[30px] text-[#353535]" style="font-family: Outfit, sans-serif;">{{ $rightTitle }}</h3>
            <ol class="mt-5 space-y-3">
                @foreach($rightItems as $item)
                    <li class="flex items-center gap-3 text-[17px] text-[#353535]">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#E0EEFE] text-sm font-semibold text-[#63A7E9]">{{ $loop->iteration }}</span>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ol>
        </article>
    </div>
</section>

