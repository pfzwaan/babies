<!-- animal blocks -->
@php
    $availableCategorySlugs = \App\Models\NameCategory::query()->pluck('slug')->all();
    $availableCategoryLookup = array_fill_keys($availableCategorySlugs, true);
    $resolveCategoryUrl = function (array $card, string $fallbackSlug) use ($availableCategoryLookup): string {
        $manualUrl = trim((string) ($card['url'] ?? ''));
        if ($manualUrl !== '' && $manualUrl !== '#') {
            return $manualUrl;
        }

        $slug = (string) ($card['category_slug'] ?? $fallbackSlug);

        return isset($availableCategoryLookup[$slug])
            ? route('names.category', ['nameCategory' => $slug])
            : route('names.archive');
    };
@endphp
<section class="bg-white relative z-0">
    <div class="max-w-container mx-auto px-6 py-[48px] md:py-[80px]">
        <div class="hidden xl:grid gap-[24px] grid-cols-5 justify-items-center mb-[24px]">
            @for($i = 0; $i < 5; $i++)
                @php
                    $defaults = [
                        ['title' => 'Hondennamen', 'description' => 'Bekijk snel onze hondennamen voor uw reu of teefje.', 'button_label' => 'Alle hondennamen', 'url' => '#', 'category_slug' => 'hondennamen'],
                        ['title' => 'Kattennamen', 'description' => 'Bekijk snel onze kattennamen voor uw kater of poes.', 'button_label' => 'Alle kattennamen', 'url' => '#', 'category_slug' => 'kattennamen'],
                        ['title' => 'Paardennamen', 'description' => 'Bekijk snel onze paardennamen.', 'button_label' => 'Alle paardennamen', 'url' => '#', 'category_slug' => 'paardennamen'],
                        ['title' => 'Konijnennamen', 'description' => 'Bekijk snel onze konijnennamen.', 'button_label' => 'Alle konijnennamen', 'url' => '#', 'category_slug' => 'konijnennamen'],
                        ['title' => 'Vissennamen', 'description' => 'Bekijk snel onze visnamen.', 'button_label' => 'Alle visnamen', 'url' => '#', 'category_slug' => 'vissennamen'],
                        ['title' => 'Vogelnamen', 'description' => 'Bekijk snel onze vogelnamen.', 'button_label' => 'Alle vogelnamen', 'url' => '#', 'category_slug' => 'vogelnamen'],
                        ['title' => 'Cavianamen', 'description' => 'Bekijk snel onze cavianamen.', 'button_label' => 'Alle cavianamen', 'url' => '#', 'category_slug' => 'cavianamen'],
                        ['title' => 'Kippennamen', 'description' => 'Bekijk snel onze kippennamen.', 'button_label' => 'Alle kippennamen', 'url' => '#', 'category_slug' => 'kippennamen'],
                        ['title' => 'Hamsternamen', 'description' => 'Bekijk snel onze hamsternamen.', 'button_label' => 'Alle hamsternamen', 'url' => '#', 'category_slug' => 'hamsternamen'],
                    ];
                    $defaultIcons = ['img/hond.png', 'img/kat.png', 'img/paard.png', 'img/konijn.png', 'img/vis.png', 'img/vogel.png', 'img/cavia.png', 'img/kip.png', 'img/hamster.png'];
                    $desktopBg = ['#F6F2ED', '#FFEAE5', '#DED6CF', '#EEF1F1', '#E7F9FC', '#F4E9FB', '#EAF7E4', '#FFF1CC', '#FFE3C2'];
                    $card = array_merge($defaults[$i], data_get($data, 'cards.' . $i, []));
                    $mediaId = $card['icon'] ?? null;
                    $mediaUrl = $mediaId ? optional(\Awcodes\Curator\Models\Media::find($mediaId))->url : null;
                    $iconUrl = $mediaUrl ?: asset($defaultIcons[$i]);
                    $cardUrl = $resolveCategoryUrl($card, $defaults[$i]['category_slug']);
                @endphp
                <div class="h-full w-full rounded-[20px] sm:rounded-[30px] p-[16px] sm:p-[24px] flex flex-col items-center text-center" style="background-color: {{ $desktopBg[$i] }}">
                    <div class="w-[48px] h-[48px] sm:w-[60px] sm:h-[60px] bg-white rounded-full flex items-center justify-center mb-[12px] sm:mb-[16px]">
                        <img src="{{ $iconUrl }}" class="w-[24px] h-[24px] sm:w-[32px] sm:h-[32px]" alt="{{ $card['title'] }}">
                    </div>
                    <h3 class="font-heading text-[18px] sm:text-[24px] md:text-[30px] leading-[22px] sm:leading-[28px] md:leading-[34px] font-semibold text-[#27304B] mb-[8px] sm:mb-[12px]">
                        {{ $card['title'] }}
                    </h3>
                    <p class="font-sans text-[13px] sm:text-[16px] md:text-[19px] leading-[18px] sm:leading-[22px] md:leading-[25px] text-[#6B7280] mb-[12px] sm:mb-[16px]">
                        {{ $card['description'] }}
                    </p>
                    <a href="{{ $cardUrl }}" class="group mt-auto w-full h-[40px] sm:h-[50px] md:h-[60px] rounded-[100px] bg-[#27304B] text-white text-[12px] sm:text-[14px] font-semibold flex items-center justify-center gap-2 hover:bg-[#1a2235] transition">
                        {{ $card['button_label'] }} <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>
            @endfor
        </div>

        <div class="hidden xl:grid gap-[24px] grid-cols-4 justify-items-center max-w-[1256px] mx-auto">
            @for($i = 5; $i < 9; $i++)
                @php
                    $defaults = [
                        ['title' => 'Hondennamen', 'description' => 'Bekijk snel onze hondennamen voor uw reu of teefje.', 'button_label' => 'Alle hondennamen', 'url' => '#', 'category_slug' => 'hondennamen'],
                        ['title' => 'Kattennamen', 'description' => 'Bekijk snel onze kattennamen voor uw kater of poes.', 'button_label' => 'Alle kattennamen', 'url' => '#', 'category_slug' => 'kattennamen'],
                        ['title' => 'Paardennamen', 'description' => 'Bekijk snel onze paardennamen.', 'button_label' => 'Alle paardennamen', 'url' => '#', 'category_slug' => 'paardennamen'],
                        ['title' => 'Konijnennamen', 'description' => 'Bekijk snel onze konijnennamen.', 'button_label' => 'Alle konijnennamen', 'url' => '#', 'category_slug' => 'konijnennamen'],
                        ['title' => 'Vissennamen', 'description' => 'Bekijk snel onze visnamen.', 'button_label' => 'Alle visnamen', 'url' => '#', 'category_slug' => 'vissennamen'],
                        ['title' => 'Vogelnamen', 'description' => 'Bekijk snel onze vogelnamen.', 'button_label' => 'Alle vogelnamen', 'url' => '#', 'category_slug' => 'vogelnamen'],
                        ['title' => 'Cavianamen', 'description' => 'Bekijk snel onze cavianamen.', 'button_label' => 'Alle cavianamen', 'url' => '#', 'category_slug' => 'cavianamen'],
                        ['title' => 'Kippennamen', 'description' => 'Bekijk snel onze kippennamen.', 'button_label' => 'Alle kippennamen', 'url' => '#', 'category_slug' => 'kippennamen'],
                        ['title' => 'Hamsternamen', 'description' => 'Bekijk snel onze hamsternamen.', 'button_label' => 'Alle hamsternamen', 'url' => '#', 'category_slug' => 'hamsternamen'],
                    ];
                    $defaultIcons = ['img/hond.png', 'img/kat.png', 'img/paard.png', 'img/konijn.png', 'img/vis.png', 'img/vogel.png', 'img/cavia.png', 'img/kip.png', 'img/hamster.png'];
                    $desktopBg = ['#F6F2ED', '#FFEAE5', '#DED6CF', '#EEF1F1', '#E7F9FC', '#F4E9FB', '#EAF7E4', '#FFF1CC', '#FFE3C2'];
                    $card = array_merge($defaults[$i], data_get($data, 'cards.' . $i, []));
                    $mediaId = $card['icon'] ?? null;
                    $mediaUrl = $mediaId ? optional(\Awcodes\Curator\Models\Media::find($mediaId))->url : null;
                    $iconUrl = $mediaUrl ?: asset($defaultIcons[$i]);
                    $cardUrl = $resolveCategoryUrl($card, $defaults[$i]['category_slug']);
                @endphp
                <div class="h-full w-full rounded-[20px] sm:rounded-[30px] p-[16px] sm:p-[24px] flex flex-col items-center text-center" style="background-color: {{ $desktopBg[$i] }}">
                    <div class="w-[48px] h-[48px] sm:w-[60px] sm:h-[60px] bg-white rounded-full flex items-center justify-center mb-[12px] sm:mb-[16px]">
                        <img src="{{ $iconUrl }}" class="w-[24px] h-[24px] sm:w-[32px] sm:h-[32px]" alt="{{ $card['title'] }}">
                    </div>
                    <h3 class="font-heading text-[18px] sm:text-[24px] md:text-[30px] leading-[22px] sm:leading-[28px] md:leading-[34px] font-semibold text-[#27304B] mb-[8px] sm:mb-[12px]">
                        {{ $card['title'] }}
                    </h3>
                    <p class="font-sans text-[13px] sm:text-[16px] md:text-[19px] leading-[18px] sm:leading-[22px] md:leading-[25px] text-[#6B7280] mb-[12px] sm:mb-[16px]">
                        {{ $card['description'] }}
                    </p>
                    <a href="{{ $cardUrl }}" class="group mt-auto w-full h-[40px] sm:h-[50px] md:h-[60px] rounded-[100px] bg-[#27304B] text-white text-[12px] sm:text-[14px] font-semibold flex items-center justify-center gap-2 hover:bg-[#1a2235] transition">
                        {{ $card['button_label'] }} <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>
            @endfor
        </div>

        <div class="grid xl:hidden gap-[12px] sm:gap-[24px] grid-cols-2 md:grid-cols-3 justify-items-center">
            @for($i = 0; $i < 9; $i++)
                @php
                    $defaults = [
                        ['title' => 'Hondennamen', 'description' => 'Bekijk snel onze hondennamen voor uw reu of teefje.', 'button_label' => 'Alle hondennamen', 'url' => '#', 'category_slug' => 'hondennamen'],
                        ['title' => 'Kattennamen', 'description' => 'Bekijk snel onze kattennamen voor uw kater of poes.', 'button_label' => 'Alle kattennamen', 'url' => '#', 'category_slug' => 'kattennamen'],
                        ['title' => 'Paardennamen', 'description' => 'Bekijk snel onze paardennamen.', 'button_label' => 'Alle paardennamen', 'url' => '#', 'category_slug' => 'paardennamen'],
                        ['title' => 'Konijnennamen', 'description' => 'Bekijk snel onze konijnennamen.', 'button_label' => 'Alle konijnennamen', 'url' => '#', 'category_slug' => 'konijnennamen'],
                        ['title' => 'Vissennamen', 'description' => 'Bekijk snel onze visnamen.', 'button_label' => 'Alle visnamen', 'url' => '#', 'category_slug' => 'vissennamen'],
                        ['title' => 'Vogelnamen', 'description' => 'Bekijk snel onze vogelnamen.', 'button_label' => 'Alle vogelnamen', 'url' => '#', 'category_slug' => 'vogelnamen'],
                        ['title' => 'Cavianamen', 'description' => 'Bekijk snel onze cavianamen.', 'button_label' => 'Alle cavianamen', 'url' => '#', 'category_slug' => 'cavianamen'],
                        ['title' => 'Kippennamen', 'description' => 'Bekijk snel onze kippennamen.', 'button_label' => 'Alle kippennamen', 'url' => '#', 'category_slug' => 'kippennamen'],
                        ['title' => 'Hamsternamen', 'description' => 'Bekijk snel onze hamsternamen.', 'button_label' => 'Alle hamsternamen', 'url' => '#', 'category_slug' => 'hamsternamen'],
                    ];
                    $defaultIcons = ['img/hond.png', 'img/kat.png', 'img/paard.png', 'img/konijn.png', 'img/vis.png', 'img/vogel.png', 'img/cavia.png', 'img/kip.png', 'img/hamster.png'];
                    $desktopBg = ['#F6F2ED', '#FFEAE5', '#DED6CF', '#EEF1F1', '#E7F9FC', '#F4E9FB', '#EAF7E4', '#FFF1CC', '#FFE3C2'];
                    $card = array_merge($defaults[$i], data_get($data, 'cards.' . $i, []));
                    $mediaId = $card['icon'] ?? null;
                    $mediaUrl = $mediaId ? optional(\Awcodes\Curator\Models\Media::find($mediaId))->url : null;
                    $iconUrl = $mediaUrl ?: asset($defaultIcons[$i]);
                    $cardUrl = $resolveCategoryUrl($card, $defaults[$i]['category_slug']);
                @endphp
                <div class="h-full w-full rounded-[20px] sm:rounded-[30px] p-[16px] sm:p-[24px] flex flex-col items-center text-center" style="background-color: {{ $desktopBg[$i] }}">
                    <div class="w-[48px] h-[48px] sm:w-[60px] sm:h-[60px] bg-white rounded-full flex items-center justify-center mb-[12px] sm:mb-[16px]">
                        <img src="{{ $iconUrl }}" class="w-[24px] h-[24px] sm:w-[32px] sm:h-[32px]" alt="{{ $card['title'] }}">
                    </div>
                    <h3 class="font-heading text-[18px] sm:text-[24px] md:text-[30px] leading-[22px] sm:leading-[28px] md:leading-[34px] font-semibold text-[#27304B] mb-[8px] sm:mb-[12px]">
                        {{ $card['title'] }}
                    </h3>
                    <p class="font-sans text-[13px] sm:text-[16px] md:text-[19px] leading-[18px] sm:leading-[22px] md:leading-[25px] text-[#6B7280] mb-[12px] sm:mb-[16px]">
                        {{ $card['description'] }}
                    </p>
                    <a href="{{ $cardUrl }}" class="group mt-auto w-full h-[40px] sm:h-[50px] md:h-[60px] rounded-[100px] bg-[#27304B] text-white text-[12px] sm:text-[14px] font-semibold flex items-center justify-center gap-2 hover:bg-[#1a2235] transition">
                        {{ $card['button_label'] }} <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>
            @endfor
        </div>
    </div>
</section>
