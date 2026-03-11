@extends('themes.babies.names.layout')

@section('title', 'Namen Archief - Babynamengids')

@section('main-content')
    <section>
        <div class="flex items-end gap-4">
            <h2 class="text-[34px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Jongensnamen op alfabet</h2>
            <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="hidden h-[52px] w-[56px] shrink-0 lg:block" />
        </div>

        <div class="mt-7 rounded-[20px] border border-[#E8EEF6] bg-white p-4 lg:p-[22px]">
            <div class="grid grid-cols-4 gap-[10px] sm:grid-cols-6 md:grid-cols-13 md:gap-[20px]">
            @foreach(range('A', 'Z') as $alpha)
                @if($categories->first())
                    <a
                        href="{{ route('names.category.letter', ['nameCategory' => $categories->first(), 'letter' => strtolower($alpha)]) }}"
                        class="flex h-[54px] items-center justify-center rounded-[16px] border bg-white text-[18px] font-semibold transition-colors md:h-[66px] md:rounded-[20px] md:text-[28px]"
                        style="{{ $alpha === 'A' ? 'border: 3px solid #FF7D97; color: #FF7D97;' : 'border-color: #E0EEFE; color: #353B52;' }}"
                    >{{ $alpha }}</a>
                @else
                    <span class="flex h-[54px] items-center justify-center rounded-[16px] border border-[#E0EEFE] bg-white text-[18px] font-semibold text-[#B9C4D0] md:h-[66px] md:rounded-[20px] md:text-[28px]">{{ $alpha }}</span>
                @endif
            @endforeach
            </div>
        </div>
    </section>

    <section>
        <div class="max-w-[1125px]">
            <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
            <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Jongensnamen</h3>
            <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Op Babynamengids.nl vind je een uitgebreide verzameling jongensnamen voor iedere smaak en stijl. Of je nu op zoek bent naar een populaire jongensnaam, een klassieke naam met een lange geschiedenis of juist een originele en unieke jongensnaam, hier vind je volop inspiratie. Het kiezen van een jongensnaam is een bijzondere stap en daarom helpen wij je met duidelijke overzichten, betekenissen en trends.</p>
        </div>

        <div class="mt-10 rounded-[30px] bg-[#F9E3BF] px-5 py-8 lg:px-[42px] lg:py-[76px]">
            <div class="max-w-[1125px]">
                <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
                <h4 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Meer jongensnamen</h4>
            </div>

            <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-[31px] lg:gap-y-8">
                @foreach($categories->take(12) as $category)
                    <article class="rounded-[20px] bg-white px-6 py-8 text-center shadow-[0_0_30px_rgba(0,0,0,0.10)]">
                        <h5 class="text-[20px] font-medium leading-[1.25] text-[#353B52]">{{ $category->name }}</h5>
                        <a href="{{ route('names.category', ['nameCategory' => $category]) }}" class="mt-4 inline-block text-[16px] font-medium leading-[1] text-[#82858C] underline">Alles bekijken</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <div class="max-w-[1125px]">
            <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
            <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">De 100 populairste jongensnamen</h3>
            <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">De Top 100 jongensnamen geeft een overzicht van de meest geliefde en beste jongensnamen van dit moment. Deze lijst is samengesteld op basis van populariteit, trends en voorkeuren van ouders. Of je nu inspiratie zoekt of wilt weten welke namen het meest gekozen worden, de Top 100 jongensnamen is een perfect startpunt bij het kiezen van een naam voor je zoon.</p>
            <a href="{{ route('names.archive') }}" class="mt-8 inline-flex h-[52px] w-full max-w-[466px] items-center justify-center rounded-full bg-[#F9E3BF] px-6 text-center text-[16px] font-semibold text-[#353B52] lg:h-[60px] lg:text-[18px]">
                <span>Bekijk de complete top 100 jongensnamen</span>
            </a>
        </div>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Populaire jongensnamen</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Populaire jongensnamen worden elk jaar opnieuw gekozen door veel ouders. Deze namen zijn geliefd vanwege hun mooie klank, sterke betekenis en herkenbaarheid. In deze categorie vind je de meest gekozen jongensnamen van dit moment, gebaseerd op trends en statistieken. Ideaal voor ouders die een naam zoeken die modern en vertrouwd aanvoelt.</p>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[60px]" style="font-family:Outfit,sans-serif;">Nederlandse en internationale jongensnamen</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Naast traditionele Nederlandse jongensnamen zijn internationale namen steeds populairder. Denk aan Engelse, Scandinavische, Franse of Spaanse jongensnamen. In deze sectie ontdek je zowel Nederlandse als buitenlandse jongensnamen, allemaal overzichtelijk gegroepeerd met hun oorsprong en betekenis.</p>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[60px]" style="font-family:Outfit,sans-serif;">Originele en unieke jongensnamen</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Wil je dat de naam van je zoon echt opvalt? Dan zijn originele en unieke jongensnamen een goede keuze. Deze namen worden minder vaak gebruikt, maar hebben vaak een bijzondere betekenis of een moderne uitstraling. Perfect voor ouders die iets anders zoeken dan de standaardnamen.</p>
    </section>

    <section class="overflow-hidden rounded-[30px]">
        <img src="{{ asset('img/babies/names-content-banner.png') }}" alt="Babynamen inspiratie banner" class="h-auto w-full" />
    </section>
@endsection
