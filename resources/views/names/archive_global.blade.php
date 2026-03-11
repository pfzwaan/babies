<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namen Archief - Dierennames</title>
    <meta name="description" content="Ontdek alle categorieen van dierennamen.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
@include('pages.header')

<main class="mx-auto w-full max-w-container px-6 pb-16">
    @php($letters = range('A', 'Z'))
    @php($defaultCategory = $categories->first())

    <p class="mb-6 mt-6 text-sm text-ink md:mt-8 md:text-[22px] md:leading-5">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        &gt;
        <span class="font-bold">Namen archief</span>
    </p>

    <section class="relative mb-10 overflow-hidden rounded-[28px] md:rounded-[50px]">
        <img src="{{ asset('img/figma/26750-13.svg') }}" alt="" aria-hidden="true" class="absolute h-[560px] w-full object-cover md:h-[855px]" />
        <div class="absolute inset-0 bg-black/45"></div>
        <div class="absolute inset-0 relative z-10 h-full flex flex-col items-center justify-center text-center px-[16px] md:px-[40px] py-[40px] md:py-[60px] text-white">
            <h1 class="max-w-[1162px] text-white font-fredoka text-[36px] font-bold leading-tight md:text-[72px] md:leading-[96px]">
                Namen voor je huisdier: vind de perfecte naam
            </h1>
            <p class="mt-6 max-w-[1171px] text-base font-medium leading-7 md:mt-8 md:text-[24px] md:leading-[35px]">
                Welkom op Dierennamengids.nl. Ontdek categorieen, initialen en populaire namen voor ieder type huisdier.
            </p>

            @include('names.partials.hero-filters', [
                'selectedCategorySlug' => request()->query('category', ''),
                'selectedGender' => request()->query('gender', ''),
                'searchQuery' => request()->query('q', ''),
            ])
        </div>
    </section>

    <div class="grid gap-8 lg:grid-cols-12">
        <div class="lg:col-span-8 xl:col-span-9">

            <!-- from figma: 26744:1398 -->
            <section class="mb-10">
                <h2 class="sr-only">Alfabet</h2>
                <div class="grid grid-cols-4 gap-3 sm:grid-cols-7 lg:grid-cols-[repeat(13,minmax(0,1fr))]">
                    @foreach($letters as $alpha)
                        @if($defaultCategory)
                            <a
                                href="{{ route('names.category.letter', ['nameCategory' => $defaultCategory, 'letter' => strtolower($alpha)]) }}"
                                class="flex h-14 items-center justify-center rounded-[10px] border border-[#C3C3C3] font-fredoka text-xl text-ink"
                            >
                                {{ $alpha }}
                            </a>
                        @else
                            <span class="flex h-14 items-center justify-center rounded-[10px] border border-[#E2E2E2] font-fredoka text-xl text-[#B0B0B0]">
                                {{ $alpha }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- from figma: 26800:341 -->
            <section class="mb-10 rounded-[30px] bg-panel p-6 md:p-10">
                <h2 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[65px]">Vind vandaag nog de perfecte naam voor jouw huisdier!</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($categories->take(10) as $category)
                        <a href="{{ route('names.category', ['nameCategory' => $category]) }}" class="rounded-[20px] bg-white p-6 text-center shadow-[0_0_30px_rgba(0,0,0,0.1)]">
                            <h3 class="font-fredoka text-xl text-ink">{{ $category->name }}</h3>
                            <p class="mt-3 font-fredoka text-base text-[#82858C] underline">Alles bekijken</p>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- from figma: 26754:206 -->
            <section class="mb-10">
                <h2 class="font-fredoka text-[30px] font-semibold leading-tight md:text-[40px] md:leading-[53px]">Top 100 dierennamen</h2>
                <p class="mt-5 text-[18px] leading-[35px] md:text-[20px]">
                    Leuke, stoere, bijzondere, gekke, grappige en originele namen: je vindt ze allemaal terug in onze top 100 dierennamen.
                </p>
                <a href="{{ route('names.archive') }}" class="mt-6 inline-flex h-[60px] items-center gap-3 rounded-[100px] bg-coral px-10 text-lg font-semibold text-white">
                    Bekijk de top 100 beste
                    <img src="{{ asset('img/figma/26837-685.svg') }}" alt="" aria-hidden="true" class="h-3 w-4" />
                </a>
            </section>

            <!-- from figma: 26744:1475 -->
            <section class="space-y-10">
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Hoe kies je de beste naam voor je huisdier?</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Een goede naam moet duidelijk, prettig en makkelijk uit te spreken zijn. Korte namen met een of twee lettergrepen worden vaak beter herkend en blijven gemakkelijker hangen.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Let op karakter, uiterlijk en energie van je huisdier. Een naam die goed past bij de persoonlijkheid voelt natuurlijk aan en versterkt jullie band.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Namen per categorie en letter</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        In dit archief vind je namen gesorteerd per categorie en beginletter. Zo kun je snel filteren en gerichter kiezen.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Kies een categorie die bij jouw dier past, open daarna een letterpagina, en vergelijk eenvoudig verschillende namen.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Populaire en originele opties</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Of je nu een klassieke naam zoekt of iets unieks, dit overzicht helpt je om sneller een keuze te maken uit honderden opties.
                    </p>
                </article>
            </section>

            <!-- from figma: 26781:689 -->
            <section class="mt-10 overflow-hidden rounded-[40px]">
                <img src="{{ asset('img/figma/26833-84.svg') }}" alt="Banner" class="h-[240px] w-full object-cover md:h-[420px]" />
            </section>
        </div>

        @include('names.partials.sidebar', [
            'title' => 'Top 10 namen',
            'ctaText' => 'Bekijk de complete top 100 namen',
            'ctaUrl' => route('names.archive'),
            'items' => $topFemale,
        ])
    </div>

    <section class="h-[100px] bg-white"></section>
</main>

@include('pages.footer')
</body>
</html>
