@extends('themes.babies.names.layout')

@section('title', $nameCategory->name . ' - Babynamengids')

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
                        style="{{ $alpha === 'A' ? 'border: 3px solid #FF7D97; color: #FF7D97;' : 'border-color: #E0EEFE; color: #353B52;' }}"
                    >{{ $alpha }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <div class="max-w-[1125px]">
            <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
            <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">{{ $nameCategory->name }}</h3>
            <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Hier vind je een overzicht van namen binnen deze categorie. Gebruik de letters bovenaan om sneller te zoeken en blader direct door de beschikbare opties.</p>
        </div>

        <div class="mt-10 rounded-[30px] bg-[#F9E3BF] p-6 lg:p-10">
            @php($columns = ($namesToRender ?? collect())->take(100)->chunk(20))
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">
                @forelse($columns as $chunk)
                    <ul class="space-y-2 text-[18px] leading-[35px] text-black">
                        @foreach($chunk as $item)
                            <li><a href="{{ route('names.show', ['nameCategory' => $nameCategory, 'name' => $item]) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                @empty
                    <p class="text-[18px] leading-[1.8] text-[#353535]">Geen namen gevonden.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section>
        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[32px] w-[39px] lg:h-[41px] lg:w-[50px]" />
        <h3 class="mt-3 text-[30px] font-bold leading-[1.02] text-[#353535] lg:text-[55px] lg:leading-[50px]" style="font-family:Outfit,sans-serif;">Over {{ $nameCategory->name }}</h3>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Gebruik de beginletters om snel door deze verzameling te bladeren. Zo vind je makkelijker een naam die goed klinkt, eenvoudig uitspreekbaar is en past bij de stijl die je zoekt.</p>
        <p class="mt-5 text-[17px] leading-[1.8] text-[#353535] lg:text-[20px] lg:leading-[35px]">Binnen {{ strtolower($nameCategory->name) }} kun je verschillende richtingen ontdekken: van bekend en tijdloos tot opvallend en origineel.</p>
    </section>
@endsection
