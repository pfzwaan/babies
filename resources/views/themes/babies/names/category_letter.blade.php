@extends('themes.babies.names.layout')

@section('title', $nameCategory->name . ' ' . $letter . ' - Babynamengids')

@section('main-content')
    <section>
        <div class="flex items-end gap-4">
            <h2 class="text-[34px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">{{ $nameCategory->name }} op alfabet</h2>
            <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="hidden h-[52px] w-[56px] shrink-0 lg:block" />
        </div>

        <div class="mt-7 rounded-[20px] border border-[#E8EEF6] bg-white p-4 lg:p-[22px]">
            <div class="grid grid-cols-4 gap-[10px] sm:grid-cols-6 md:grid-cols-13 md:gap-[20px]">
                @foreach($letters as $alpha)
                    <a
                        href="{{ route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => strtolower($alpha)]) }}"
                        class="flex h-[54px] items-center justify-center rounded-[16px] border bg-white text-[18px] font-semibold transition-colors md:h-[66px] md:rounded-[20px] md:text-[28px]"
                        style="{{ $alpha === $letter ? 'border: 3px solid #FF7D97; color: #FF7D97;' : 'border-color: #E0EEFE; color: #353B52;' }}"
                    >{{ $alpha }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section>
        @php($topLetterNames = ($namesToRender ?? collect())->take(10)->values())
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Top 10 {{ strtolower($nameCategory->name) }} met een {{ $letter }}</h3>

        <div class="mt-10 rounded-[30px] bg-[#63A7E9] p-[18px] lg:p-[22px]">
            <div class="rounded-[30px] bg-white px-7 py-8 lg:px-[51px] lg:py-[44px]">
                @if($topLetterNames->isNotEmpty())
                    @php($chunks = $topLetterNames->chunk(4))
                    <div class="grid gap-x-10 gap-y-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($chunks as $chunk)
                            <ul class="space-y-5">
                                @foreach($chunk as $item)
                                    <li>
                                        <a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}" class="flex items-center gap-3 text-[22px] leading-[1.2] text-black lg:text-[28px]" style="font-family:Onest,sans-serif;">
                                            <span class="inline-flex h-[39px] w-[39px] shrink-0 items-center justify-center rounded-full bg-[rgba(99,167,233,0.35)]">
                                                <svg class="h-[18px] w-[20px] shrink-0 text-[#63A7E9]" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M4.62732 0.0231372C0.10863 -0.403283 -1.0276 5.16335 0.899619 8.56081C3.25074 12.7045 7.95735 16.4913 12.2226 17.9096C12.3755 17.9606 12.5328 18.0116 12.6902 17.9977C12.913 17.9745 13.101 17.8308 13.2801 17.6918C16.042 15.5133 18.5024 12.7879 19.5469 9.1819C20.3073 6.98955 20.2592 3.84701 18.2402 2.41943C15.5657 0.532986 12.6945 3.4484 11.9036 6.04864C11.5889 4.7184 10.5095 3.77749 9.70102 2.75315C8.59975 1.35802 6.55891 0.213173 4.62732 0.0277732V0.0231372Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <span>{{ $loop->parent->iteration === 1 ? $loop->iteration : (($loop->parent->iteration - 1) * 4) + $loop->iteration }}. {{ $item->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                @else
                    <p class="text-[18px] leading-[1.8] text-[#353535]">Geen namen gevonden voor de letter {{ $letter }}.</p>
                @endif
            </div>
        </div>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Namen met een {{ $letter }}</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Zoeken op beginletter maakt het makkelijker om namen te vergelijken op klank, lengte en stijl. Met de letter {{ $letter }} ontdek je snel welke namen binnen {{ strtolower($nameCategory->name) }} het beste passen bij wat je zoekt.</p>

        <div class="mt-10 rounded-[30px] bg-[#E0EEFE] px-6 py-8 lg:px-[63px] lg:py-[55px]">
            @php($columns = ($namesToRender ?? collect())->take(100)->chunk(20))
            <div class="grid gap-x-8 gap-y-2 md:grid-cols-2 lg:grid-cols-5">
                @forelse($columns as $chunk)
                    <ul class="space-y-0 text-[18px] leading-[35px] text-black" style="font-family:Onest,sans-serif;">
                        @foreach($chunk as $item)
                            <li><a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                @empty
                    <p class="text-[18px] leading-[1.8] text-[#353535]">Geen namen gevonden voor de letter {{ $letter }}.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Waarom kiezen voor namen met {{ $letter }}?</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Namen met de letter {{ $letter }} hebben vaak een duidelijke en herkenbare klank. Ze komen voor in verschillende stijlen en kunnen zowel klassiek als modern aanvoelen, waardoor je makkelijker een richting kiest die bij jouw voorkeur past.</p>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[60px]" style="font-family:Outfit,sans-serif;">Nederlandse en internationale namen met {{ $letter }}</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Binnen {{ strtolower($nameCategory->name) }} met de letter {{ $letter }} vind je vaak zowel Nederlandse als internationale opties. Daardoor kun je namen vergelijken op herkomst, uitstraling en betekenis, zonder het overzicht te verliezen.</p>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[60px]" style="font-family:Outfit,sans-serif;">Populaire en originele namen met {{ $letter }}</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Sommige namen met de letter {{ $letter }} zijn al jaren geliefd, terwijl andere juist verrassend en minder bekend zijn. Door beide naast elkaar te bekijken, zie je sneller of je voorkeur uitgaat naar iets vertrouwd of juist uniek.</p>
    </section>

    <section class="overflow-hidden rounded-[30px]">
        <img src="{{ asset('img/babies/category-letter-banner.png') }}" alt="Namen inspiratie banner" class="h-auto w-full" />
    </section>
@endsection
