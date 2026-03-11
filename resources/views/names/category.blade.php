<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nameCategory->name }} - Dierennames</title>
    <meta name="description" content="Ontdek de mooiste {{ strtolower($nameCategory->name) }} voor jouw nieuwe huisdier.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
@include('pages.header')

<main class="mx-auto w-full max-w-container px-6 pb-16">
    @php($categoryLabel = strtolower($nameCategory->name))
    @php($namesList = ($namesToRender ?? collect())->take(100))
    <p class="mb-6 mt-6 text-sm text-ink md:mt-8 md:text-[22px] md:leading-5">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        &gt;
        <a href="{{ route('names.archive') }}" class="hover:underline">Namen archief</a>
        &gt;
        <span class="font-bold">{{ $nameCategory->name }}</span>
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

            <!-- from figma: 26803:910 -->
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

            <!-- from figma: 26803:907 -->
            <section class="mb-10">
                <h2 class="font-fredoka text-[30px] font-semibold leading-tight md:text-[40px] md:leading-[53px]">
                    Krachtige {{ $categoryLabel }} voor jouw huisdier
                </h2>
                <p class="mt-5 text-[18px] leading-[35px] md:text-[20px]">
                    Het kiezen van de perfecte naam is een van de belangrijkste eerste stappen. Hieronder vind je populaire en originele {{ $categoryLabel }} die sterk klinken, makkelijk uit te spreken zijn en goed blijven hangen.
                </p>
            </section>

            <!-- from figma: 26803:84 -->
            <section class="mb-10">
                <h2 class="font-fredoka text-[30px] font-semibold leading-tight md:text-[40px] md:leading-[53px]">Top 100 {{ $categoryLabel }}</h2>
                <p class="mt-5 text-[18px] leading-[35px] md:text-[20px]">Leuke, stoere, bijzondere, gekke, grappige en originele namen: je vindt ze allemaal terug in onze top 100 {{ $categoryLabel }}.</p>
                <a href="{{ route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => 'a']) }}" class="mt-6 inline-flex h-[60px] items-center gap-3 rounded-[100px] bg-coral px-10 text-lg font-semibold text-white">
                    Bekijk de top 100 beste
                    <img src="{{ asset('img/figma/26837-685.svg') }}" alt="" aria-hidden="true" class="h-3 w-4" />
                </a>
            </section>

            <!-- from figma: 26803:838 -->
            <section class="mb-10 rounded-[30px] bg-ink p-5 md:p-11">
                <header class="mb-6 flex items-center gap-3 md:mb-7 md:gap-4">
                    <img src="{{ asset('img/figma/26809-50.svg') }}" alt="" aria-hidden="true" class="h-[42px] w-[42px] md:h-[60px] md:w-[60px]" />
                    <h2 class="font-fredoka text-[28px] font-medium leading-tight text-white md:text-[40px] md:leading-[40px]">
                        Top 100 {{ $categoryLabel }}
                    </h2>
                </header>
                <div class="rounded-[30px] bg-white px-6 py-8 md:px-[50px] md:py-9">
                    @php($columns = $namesList->chunk(max((int) ceil(max($namesList->count(), 1) / 3), 1)))
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($columns as $column)
                            <ul class="space-y-1 text-[18px] leading-[30px] md:text-[20px] md:leading-[35px]">
                                @foreach($column as $item)
                                    <li>
                                        <a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @empty
                            <p class="text-[18px] leading-[30px]">Nog geen namen beschikbaar.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- from figma: 26803:831 -->
            <section class="space-y-10">
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Hoe kies je de beste naam voor je huisdier?</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Een goede naam moet aan een aantal belangrijke kenmerken voldoen. Korte namen, met een of twee lettergrepen, worden meestal aanbevolen omdat dieren ze gemakkelijker herkennen en leren. Het is ook slim om namen te vermijden die te veel lijken op basiscommando's.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Observeer je huisdier gedurende de eerste paar dagen: energieniveau, temperament en gedrag geven vaak aanwijzingen voor de ideale naam. Een naam die past bij de persoonlijkheid versterkt de band tussen jou en je dier.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Namen voor mannetjes en vrouwtjes</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Op deze pagina vind je namen voor mannetjes en vrouwtjes, georganiseerd per categorie om het zoeken te vergemakkelijken. We hebben ook unisex namen opgenomen, ideaal als je de voorkeur geeft aan iets neutraals of moderns.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Namen voor mannetjes: Sterk, Klassiek, Modern of Grappig<br>
                        Namen voor vrouwtjes: Lief, Elegant, Origineel of Schattig<br>
                        Unisex namen: Kort, Populair en Makkelijk uit te spreken<br>
                        Dankzij deze variatie vind je gegarandeerd een naam die perfect past.
                    </p>
                </article>
                <article>
                    <h3 class="font-fredoka text-2xl font-semibold md:text-[40px] md:leading-[53px]">Namen op basis van grootte en persoonlijkheid</h3>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Grootte en persoonlijkheid spelen ook een rol bij de keuze van een naam. Voor grotere dieren werken namen met kracht en uitstraling vaak goed, terwijl bij kleinere dieren speelse of zachte namen populair zijn.
                    </p>
                    <p class="mt-4 text-[18px] leading-[35px]">
                        Je kunt ook kiezen op basis van karakter:<br>
                        Rustig: zachte en aanhankelijke namen<br>
                        Speels: leuke en vrolijke namen<br>
                        Dapper of beschermend: sterke en karaktervolle namen<br>
                        Deze categorieen helpen je een naam te vinden die je huisdier echt vertegenwoordigt.
                    </p>
                </article>
            </section>

            <!-- from figma: 26803:828 -->
            <section class="mt-10 overflow-hidden rounded-[40px]">
                <img src="{{ asset('img/figma/26803-828.svg') }}" alt="Banner" class="h-[240px] w-full object-cover md:h-[420px]" />
            </section>
        </div>

        @include('names.partials.sidebar', [
            'title' => 'Top 10 ' . $categoryLabel,
            'ctaText' => 'Bekijk de complete top 100 namen',
            'ctaUrl' => route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => 'a']),
            'items' => $topFemale,
            'nameCategory' => $nameCategory,
        ])
    </div>

    <section class="h-[100px] bg-white"></section>
</main>

@include('pages.footer')
</body>
</html>
