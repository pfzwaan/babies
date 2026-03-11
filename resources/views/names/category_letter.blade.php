<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nameCategory->name }} {{ $letter }} - Dierennames</title>
    <meta name="description" content="Ontdek {{ strtolower($nameCategory->name) }} met de letter {{ $letter }}.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
@include('pages.header')

<main class="mx-auto w-full max-w-container px-6 pb-16">
    @php($categoryLabel = strtolower($nameCategory->name))
    <p class="mb-6 mt-6 text-sm text-ink md:mt-8 md:text-[22px] md:leading-5">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        &gt;
        <a href="{{ route('names.archive') }}" class="hover:underline">Namen archief</a>
        &gt;
        <a href="{{ route('names.category', ['nameCategory' => $nameCategory]) }}" class="hover:underline">{{ $nameCategory->name }}</a>
        &gt;
        <span class="font-bold">{{ $letter }}</span>
    </p>

    <section class="relative mb-10 overflow-hidden rounded-[28px] md:rounded-[50px]">
        <img src="{{ asset('img/figma/26750-13.svg') }}" alt="" aria-hidden="true" class="absolute h-[560px] w-full object-cover md:h-[855px]" />
        <div class="absolute inset-0 bg-black/45"></div>
        <div class="absolute inset-0 relative z-10 h-full flex flex-col items-center justify-center text-center px-[16px] md:px-[40px] py-[40px] md:py-[60px] text-white">
            <h1 class="max-w-[1162px] text-white font-fredoka text-[36px] font-bold leading-tight md:text-[72px] md:leading-[96px]">
                Namen voor je <span class="text-lime">{{ $categoryLabel }}:</span> vind de perfecte naam
            </h1>
            <p class="mt-6 max-w-[1171px] text-base font-medium leading-7 md:mt-8 md:text-[24px] md:leading-[35px]">
                Welkom op de website vol met {{ $categoryLabel }}. Dierennamengids.nl is de meest complete website in Nederland voor wat betreft huisdiernamen.
            </p>

            @include('names.partials.hero-filters', [
                'selectedCategorySlug' => $nameCategory->slug,
                'selectedGender' => $activeGender ?? request()->query('gender', ''),
                'searchQuery' => $activeQuery ?? request()->query('q', ''),
            ])
        </div>
    </section>

    <div class="grid gap-8 lg:grid-cols-12">
        <div class="lg:col-span-8 xl:col-span-9">
            <!-- from figma: 26784:966 -->
            <section class="mb-10">
                <h2 class="sr-only">Alfabet</h2>
                <div class="grid grid-cols-4 gap-3 sm:grid-cols-7 lg:grid-cols-[repeat(13,minmax(0,1fr))]">
                    @foreach($letters as $alpha)
                        <a
                            href="{{ route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => strtolower($alpha)]) }}"
                            class="flex h-14 items-center justify-center rounded-[10px] border font-fredoka text-xl text-ink {{ $alpha === $letter ? 'border-2 border-coral' : 'border-[#C3C3C3]' }}"
                        >
                            {{ $alpha }}
                        </a>
                    @endforeach
                </div>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a
                        href="{{ route('names.category.gender', ['nameCategory' => $nameCategory, 'genderSlug' => 'reu']) }}"
                        class="inline-flex h-14 items-center rounded-full bg-[#F2643D] px-8 text-base font-semibold text-white transition hover:bg-[#E55630] {{ ($activeGender ?? null) === 'male' ? 'ring-2 ring-[#F8B39F]' : '' }}"
                    >
                        Reu
                    </a>
                    <a
                        href="{{ route('names.category.gender', ['nameCategory' => $nameCategory, 'genderSlug' => 'teefje']) }}"
                        class="inline-flex h-14 items-center rounded-full bg-[#F2643D] px-8 text-base font-semibold text-white transition hover:bg-[#E55630] {{ ($activeGender ?? null) === 'female' ? 'ring-2 ring-[#F8B39F]' : '' }}"
                    >
                        Teefje
                    </a>
                </div>
            </section>

            <!-- from figma: 26786:1103 -->
            <section class="mb-10">
                <h2 class="font-fredoka text-[30px] font-semibold leading-tight md:text-[40px] md:leading-[53px]">
                    {{ ucfirst($categoryLabel) }} met de letter {{ $letter }}
                </h2>
                <p class="mt-5 text-[18px] leading-[32px] md:text-[20px] md:leading-[35px]">
                    Ben je op zoek naar {{ $categoryLabel }} met de letter {{ $letter }}? Dan ben je hier precies waar je moet zijn. Het kiezen van een naam is een belangrijke stap, omdat je deze naam dagelijks zult gebruiken.
                </p>
                <p class="mt-4 text-[18px] leading-[32px] md:text-[20px] md:leading-[35px]">
                    Namen die beginnen met de letter {{ $letter }} zijn populair omdat ze krachtig klinken en vaak eenvoudig te herkennen zijn. Vooral korte namen met een of twee lettergrepen zijn ideaal voor training en dagelijkse communicatie.
                </p>
            </section>

            <!-- from figma: 26786:1103 -->
            <section class="rounded-[30px] bg-ink p-5 md:p-11">
                <header class="mb-6 flex items-center gap-3 md:mb-7 md:gap-4">
                    <img src="{{ asset('img/figma/26809-50.svg') }}" alt="" aria-hidden="true" class="h-[42px] w-[42px] md:h-[60px] md:w-[60px]" />
                    <h2 class="font-fredoka text-[28px] font-medium leading-tight text-white md:text-[40px] md:leading-[40px]">
                        Top 10 {{ $categoryLabel }} met de letter {{ $letter }}
                    </h2>
                </header>
                <div class="rounded-[30px] bg-white px-6 py-8 md:px-[50px] md:py-9">
                    @php($topTen = $namesToRender->take(10))
                    @php($columns = $topTen->chunk(4))
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($columns as $column)
                            <ul class="space-y-4 text-[24px] md:text-[28px] md:leading-[60px]">
                                @foreach($column as $item)
                                    <li class="flex items-center gap-3">
                                        <span class="inline-flex h-[39px] w-[39px] items-center justify-center rounded-full bg-ink">
                                            <img src="{{ asset('img/figma/26786-1118.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[18px]" />
                                        </span>
                                        <a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- from figma: 26786:1213 -->
            <section class="mt-10">
                <h2 class="font-fredoka text-[30px] font-semibold leading-tight md:text-[40px] md:leading-[53px]">
                    Namen met een {{ $letter }}
                </h2>
                <p class="mt-5 text-[18px] leading-[32px] md:text-[20px] md:leading-[35px]">
                    De letter {{ $letter }} is een populaire keuze bij het zoeken naar een mooie en passende naam. Namen met een {{ $letter }} hebben vaak een zachte maar duidelijke klank, wat ze ideaal maakt voor huisdieren. Ze zijn makkelijk uit te spreken en blijven goed hangen, zowel voor de eigenaar als voor het dier zelf.
                </p>
                <section class="rounded-[30px] bg-panel p-6 md:p-10 mt-10">
                    @php($nameColumns = $namesToRender->chunk(ceil(max($namesToRender->count(), 1) / 5)))
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                        @foreach($nameColumns as $chunk)
                            <div class="space-y-1 text-[18px] leading-[35px]">
                                @foreach($chunk as $item)
                                    @php($isAshe = strcasecmp($item->title, 'Ashe') === 0)
                                    <p>
                                        <a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}" class="{{ $isAshe ? 'font-bold underline text-[#353C52]' : '' }}">
                                            {{ $isAshe ? '> Ashe' : $item->title }}
                                        </a>
                                    </p>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </section>
            </section>

            <!-- from figma: 26784:887 -->
            <section class="space-y-10 mt-10">
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Waarom kiezen voor {{ $categoryLabel }} met de letter {{ $letter }}?</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        De letter {{ $letter }} heeft een open en sterke klank, wat helpt om namen sneller te herkennen. Veel mensen kiezen bewust voor namen die beginnen met een klinker, omdat deze duidelijk doorklinken, zelfs op afstand.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        In deze lijst met {{ $categoryLabel }} met {{ $letter }} vind je zowel klassieke als moderne opties. Of je dier nu speels, rustig, stoer of juist lief is, er is altijd een naam die perfect past.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Tips voor het kiezen van een naam</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Bij het kiezen van een naam is het goed om met een paar zaken rekening te houden:<br>
                        Kies een korte en duidelijke naam<br>
                        Vermijd namen die lijken op veelgebruikte commando's<br>
                        Denk na of de naam ook later goed blijft passen<br>
                        Zeg de naam hardop om te horen of hij prettig klinkt<br>
                        Deze pagina toont namen alfabetisch gesorteerd, zodat je eenvoudig kunt zoeken en vergelijken.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Vind vandaag nog de perfecte naam</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        De juiste naam versterkt de band tussen jou en je huisdier. Met onze zorgvuldig samengestelde selectie van {{ $categoryLabel }} met de letter {{ $letter }} helpen we je graag bij het maken van de juiste keuze.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Blader door de namen, combineer ze met je gevoel en kies een naam die je met trots zult gebruiken.
                    </p>
                </article>
            </section>
        </div>

        @include('names.partials.sidebar', [
            'title' => 'Top 10 ' . $categoryLabel,
            'ctaText' => 'Bekijk de complete top 100 namen',
            'items' => $topFemale,
            'nameCategory' => $nameCategory,
        ])
    </div>

    <section class="h-[100px] bg-white"></section>
</main>

@include('pages.footer')
</body>
</html>
