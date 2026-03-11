@php($nameCategories = \App\Models\NameCategory::query()->orderBy('name')->get(['id', 'name', 'slug']))
@php($selectedCategorySlug = $selectedCategorySlug ?? (string) request()->query('category', ''))
@php($selectedGender = $selectedGender ?? (string) request()->query('gender', ''))
@php($searchQuery = $searchQuery ?? (string) request()->query('q', ''))

<div class="mt-8 w-full max-w-[1440px] rounded-[16px] bg-white px-[16px] py-[16px] font-sans shadow-lg md:mt-10 md:rounded-[24px] md:px-[24px] md:py-[20px]">
    <div class="grid grid-cols-1 gap-[12px] sm:grid-cols-2 lg:grid-cols-4 md:gap-[16px]">
        <div class="text-left">
            <label class="mb-[8px] block text-[14px] font-semibold leading-[15px] text-[#111827] md:text-[18px]">Huisdiersoort:</label>
            <div class="relative">
                <select
                    name="category"
                    form="hero-filters-form"
                    class="h-[44px] w-full appearance-none rounded-[8px] border border-[#E5E7EB] bg-white px-[12px] pr-[36px] text-[14px] font-normal text-[#111827]"
                >
                    <option value="">Kies een categorie</option>
                    @foreach($nameCategories as $category)
                        <option value="{{ $category->slug }}" @selected($selectedCategorySlug === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none absolute right-[12px] top-1/2 h-4 w-4 -translate-y-1/2 text-[#F2643D]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <div class="text-left">
            <label class="mb-[8px] block text-[14px] font-semibold leading-[15px] text-[#111827] md:text-[18px]">Geslacht:</label>
            <div class="relative">
                <select
                    name="gender"
                    form="hero-filters-form"
                    class="h-[44px] w-full appearance-none rounded-[8px] border border-[#E5E7EB] bg-white px-[12px] pr-[36px] text-[14px] font-normal text-[#111827]"
                >
                    <option value="">Alle</option>
                    <option value="male" @selected($selectedGender === 'male')>Mannelijk</option>
                    <option value="female" @selected($selectedGender === 'female')>Vrouwelijk</option>
                </select>
                <svg class="pointer-events-none absolute right-[12px] top-1/2 h-4 w-4 -translate-y-1/2 text-[#F2643D]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <div class="text-left sm:col-span-2 lg:col-span-1">
            <label class="mb-[8px] block text-[14px] font-semibold leading-[15px] text-[#111827] md:text-[18px]">Trefwoorden:</label>
            <input
                type="text"
                name="q"
                value="{{ $searchQuery }}"
                form="hero-filters-form"
                placeholder="Trefwoorden invoeren"
                class="h-[44px] w-full rounded-[8px] border border-[#E5E7EB] px-[12px] text-[14px] font-normal text-[#111827] placeholder:text-[#9CA3AF]"
            />
        </div>

        <div class="flex items-end sm:col-span-2 lg:col-span-1">
            <form id="hero-filters-form" method="GET" action="{{ route('names.search') }}" class="w-full">
                <button
                    type="submit"
                    class="flex h-[44px] w-full items-center justify-center gap-[8px] whitespace-nowrap rounded-full bg-[#F2643D] px-[28px] text-[14px] font-semibold text-white transition hover:bg-[#E55630]"
                >
                    <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.6-5.15a6.75 6.75 0 11-13.5 0 6.75 6.75 0 0113.5 0z"/>
                    </svg>
                    Namen zoeken
                </button>
            </form>
        </div>
    </div>
</div>
