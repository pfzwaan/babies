@php
    $titlePrefix = $data['title_prefix'] ?? 'Vind de perfecte';
    $titleHighlight = $data['title_highlight'] ?? 'naam';
    $titleSuffix = $data['title_suffix'] ?? 'voor je baby';
    $subtitle = $data['subtitle'] ?? 'Ontdek populaire, moderne en unieke namen om inspiratie op te doen en de ideale naam voor je kleintje te kiezen.';

    $nameCategories = \App\Models\NameCategory::query()->forSite(\App\Models\Site::resolveCurrent()?->id)->orderBy('name')->get(['id', 'name', 'slug']);
    $selectedCategory = (string) request()->query('category', '');
    $selectedGender = (string) request()->query('gender', '');
    $searchQuery = (string) request()->query('q', '');
@endphp

<section class="relative overflow-hidden bg-[#F9E3BF] lg:-mt-[30px] lg:min-h-[748px]">
    <img src="{{ asset('img/babies/hero-ornaments.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-1/2 top-[40px] hidden w-[1518px] max-w-none -translate-x-1/2 opacity-35 lg:block" />

    <div class="relative container mx-auto pt-10 pb-12 md:pt-12 md:pb-14 lg:pt-[105px] lg:pb-[56px]">
        <h1 class="mx-auto max-w-[1125px] text-center text-[42px] font-bold leading-[48px] text-[#2f2f2f] md:text-[55px] md:leading-[50px]" style="font-family: Outfit, sans-serif;">
            {{ $titlePrefix }} <span class="text-[#FF7D97]">{{ $titleHighlight }}</span> {{ $titleSuffix }}
        </h1>

        <div class="mx-auto mt-6 w-full max-w-[1290px] text-center text-[20px] font-medium leading-[36px] text-[#4e4b46] md:text-[24px] md:leading-[45px]">
            {{ $subtitle }}
        </div>

        <div class="mx-auto mt-10 w-full max-w-[1446px] rounded-[20px] bg-white px-4 py-6 md:px-8 md:py-8 lg:mt-9 lg:px-[45px] lg:py-[48px]">
            <form method="GET" action="{{ route('names.search') }}" class="grid gap-5 lg:grid-cols-[260px_260px_540px_239px] lg:items-end lg:gap-[19px]">
                <div class="grid gap-2">
                    <label class="text-[18px] font-semibold leading-[15px] text-[#393939]">Selecteer herkomst</label>
                    <div class="relative">
                        <select name="category" class="h-[60px] w-full rounded-[5px] border border-[#d7d7d7] px-[11px] text-left text-[18px] font-normal leading-[15px] text-[#565656]">
                            <option value="">Alle herkomsten</option>
                            @foreach($nameCategories as $category)
                                <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-2">
                    <label class="text-[18px] font-semibold leading-[15px] text-[#393939]">Geslacht</label>
                    <select name="gender" class="h-[60px] w-full rounded-[5px] border border-[#d7d7d7] px-[11px] text-left text-[18px] font-normal leading-[15px] text-[#565656]">
                        <option value="">Alle</option>
                        <option value="male" @selected($selectedGender === 'male')>Jongensnaam</option>
                        <option value="female" @selected($selectedGender === 'female')>Meisjesnaam</option>
                    </select>
                </div>

                <div class="grid gap-2">
                    <label class="text-[18px] font-semibold leading-[15px] text-transparent">.</label>
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Zoek naar namen die beginnen met de eerste letter" class="h-[60px] w-full rounded-[5px] border border-[#d7d7d7] px-5 text-[18px] font-normal leading-[15px] text-[#565656]" />
                </div>

                <button type="submit" class="h-[60px] rounded-full bg-[#FF7D97] text-[19px] font-semibold leading-[15.6px] text-white">
                    Zoek naar namen
                </button>
            </form>
        </div>
    </div>
</section>


