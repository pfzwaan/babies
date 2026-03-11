@php
    $global = \App\Models\GlobalContent::singleton();
    $headerNavigation = \App\Models\Navigation::publishedForLocation('header-menu');
    $items = $headerNavigation?->resolvedItems() ?? [];

    if ($items === []) {
        $items = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Jongensnamen', 'url' => '/namen'],
            ['label' => 'Meisjesnamen', 'url' => '/namen'],
            ['label' => 'Unisex namen', 'url' => '/namen'],
            ['label' => 'Blog', 'url' => '/blog'],
        ];
    }

    $ctaLabel = $global->header_cta_label ?: 'Inloggen';
    $ctaUrl = $global->header_cta_url ?: '#';
@endphp

<header class="fixed top-0 z-50 w-full">
    <div class="relative mx-auto hidden h-[201px] w-full lg:block">
        <div class="h-[182px] bg-white">
            <div class="container mx-auto grid h-full grid-cols-[1fr_auto_1fr] pt-[19px] px-6">
                <div></div>
                <a href="{{ url('/') }}"><img src="{{ asset('img/babies/logo.svg') }}" alt="Babynamengids" class="h-[71px] w-[266px]" /></a>
                <a href="{{ $ctaUrl }}" class="mt-[6px] inline-flex h-[60px] w-[219px] items-center justify-center justify-self-end rounded-full bg-[#FF7D97] text-[19px] font-semibold leading-[15.6px] text-white">{{ $ctaLabel }}</a>
            </div>
        </div>

        <div class="absolute inset-x-0 top-[137px] h-[64px] overflow-hidden">
            <div class="h-full w-full" style="background-image:url('{{ asset('img/babies/menu-wave.svg') }}');background-repeat:repeat-x;background-position:top left;background-size:auto 64px;filter:drop-shadow(0 0px 2px rgba(0,0,0,0.1));"></div>
            <nav class="absolute inset-0 container mx-auto flex h-full items-start justify-center pt-[3px] text-center text-[18px] uppercase tracking-[1px] text-[#2f2f2f]" aria-label="Main navigation">
                @foreach($items as $index => $item)
                    @if($index > 0)
                        <span class="px-5 font-normal">&bull;</span>
                    @endif
                    <a
                        href="{{ $item['url'] ?? '#' }}"
                        @if(! empty($item['open_in_new_tab'])) target="_blank" rel="noopener noreferrer" @endif
                        class="{{ $index === 0 ? 'font-bold' : 'font-normal' }}"
                    >{{ $item['label'] ?? '' }}</a>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="lg:hidden">
        <div class="bg-white">
            <div class="container mx-auto flex items-center justify-between px-4 py-4 md:px-6">
                <a href="{{ url('/') }}"><img src="{{ asset('img/babies/logo.svg') }}" alt="Babynamengids" class="h-auto w-44 md:w-[220px]" /></a>
                <div class="flex items-center gap-3">
                    <a href="{{ $ctaUrl }}" class="hidden h-11 rounded-full bg-[#FF7D97] px-5 text-sm font-semibold text-white sm:inline-flex sm:items-center">{{ $ctaLabel }}</a>
                    <button id="mobile-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu-panel" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#d7d7d7] bg-white text-[#2f2f2f]">
                        <span class="relative flex h-4 w-5 flex-col items-center justify-between">
                            <span id="mobile-menu-line-top" class="block h-[2px] w-5 rounded-full bg-[#2f2f2f] transition-all duration-200"></span>
                            <span id="mobile-menu-line-middle" class="block h-[2px] w-5 rounded-full bg-[#2f2f2f] transition-all duration-200"></span>
                            <span id="mobile-menu-line-bottom" class="block h-[2px] w-5 rounded-full bg-[#2f2f2f] transition-all duration-200"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="relative h-[52px] overflow-hidden">
            <div class="h-full w-full" style="background-image:url('{{ asset('img/babies/menu-wave.svg') }}');background-repeat:repeat-x;background-position:top left;background-size:auto 52px;filter:drop-shadow(0 0px 2px rgba(0,0,0,0.1));"></div>
        </div>
        <nav id="mobile-menu-panel" class="hidden border-t border-[#efefef] bg-white shadow-[0_10px_28px_rgba(0,0,0,0.08)]" aria-label="Mobile menu">
            <div class="container mx-auto grid gap-1 px-4 py-4 md:px-6">
                @foreach($items as $item)
                    <a href="{{ $item['url'] ?? '#' }}" @if(! empty($item['open_in_new_tab'])) target="_blank" rel="noopener noreferrer" @endif class="rounded-xl px-4 py-3 text-sm font-semibold uppercase tracking-[0.8px] text-[#2f2f2f] hover:bg-[#E0EEFE]">{{ $item['label'] ?? '' }}</a>
                @endforeach
                <a href="{{ $ctaUrl }}" class="mt-2 inline-flex h-11 items-center justify-center rounded-full bg-[#FF7D97] px-5 text-sm font-semibold text-white sm:hidden">{{ $ctaLabel }}</a>
            </div>
        </nav>
    </div>
</header>

<script>
(function () {
    var toggleButton = document.getElementById('mobile-menu-toggle');
    var panel = document.getElementById('mobile-menu-panel');
    var topLine = document.getElementById('mobile-menu-line-top');
    var middleLine = document.getElementById('mobile-menu-line-middle');
    var bottomLine = document.getElementById('mobile-menu-line-bottom');

    if (!toggleButton || !panel || !topLine || !middleLine || !bottomLine) return;

    var closeMenu = function () {
        panel.classList.add('hidden');
        topLine.classList.remove('translate-y-[6px]', 'rotate-45');
        middleLine.classList.remove('opacity-0');
        bottomLine.classList.remove('-translate-y-[6px]', '-rotate-45');
        toggleButton.setAttribute('aria-label', 'Open menu');
        toggleButton.setAttribute('aria-expanded', 'false');
    };

    var openMenu = function () {
        panel.classList.remove('hidden');
        topLine.classList.add('translate-y-[6px]', 'rotate-45');
        middleLine.classList.add('opacity-0');
        bottomLine.classList.add('-translate-y-[6px]', '-rotate-45');
        toggleButton.setAttribute('aria-label', 'Close menu');
        toggleButton.setAttribute('aria-expanded', 'true');
    };

    toggleButton.addEventListener('click', function () {
        if (panel.classList.contains('hidden')) {
            openMenu();
        } else {
            closeMenu();
        }
    });

    panel.querySelectorAll('a').forEach(function (item) {
        item.addEventListener('click', closeMenu);
    });
})();
</script>


