@php
    $headerNavigation = \App\Models\Navigation::publishedForLocation('header-menu');
    $headerItems = $headerNavigation?->resolvedItems() ?? [];
@endphp

<header class="site-header shadow-[0_4px_20px_rgba(0,0,0,0.1)] relative z-50" style="background-color: var(--site-header-bg, #ffffff);">
    <nav
        class="max-w-container mx-auto px-6 font-sans"
    >
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="/" aria-label="Go to home">
                    <img src="/img/logo.png" alt="Dierennamengids" class="h-12 w-auto">
                </a>
            </div>

            <!-- Desktop menu -->
            <div
                class="hidden md:flex items-center gap-12
                       font-bold text-[18px] leading-[25px] tracking-[0px]"
            >
                @foreach($headerItems as $item)
                    @if(($item['children'] ?? []) !== [])
                        <!-- Dropdown -->
                        <div
                            class="relative group"
                        >
                            <button
                                class="flex items-center gap-1 text-gray-900 hover:text-[#F2613F] transition-colors"
                            >
                                {{ $item['label'] }}
                                <svg
                                    class="w-4 h-4 mt-[1px] transition-transform duration-200 group-hover:rotate-180 group-focus-within:rotate-180"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                class="absolute left-1/2 top-full -translate-x-1/2 w-[480px] bg-white shadow-xl rounded-2xl overflow-hidden
                                       text-[15px] font-normal border border-gray-100 z-50
                                       opacity-0 invisible pointer-events-none translate-y-1
                                       group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto group-hover:translate-y-0
                                       group-focus-within:opacity-100 group-focus-within:visible group-focus-within:pointer-events-auto group-focus-within:translate-y-0
                                       transition-all duration-200"
                            >
                                @foreach($item['children'] as $child)
                                    <a
                                        href="{{ $child['url'] }}"
                                        @if($child['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                                        class="block px-6 py-4 hover:bg-gray-50 transition-colors @if(!$loop->first) border-t border-gray-100 @endif"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a
                            href="{{ $item['url'] }}"
                            @if($item['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                            class="text-gray-900 hover:text-[#F2613F] transition-colors"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach

                <!-- Login button -->
                <a
                    href="#"
                    class="group ml-2 bg-[#F2613F] text-white
                           font-bold text-[16px] leading-[22px]
                           px-6 py-3 rounded-full
                           hover:bg-[#d94e2e] hover:shadow-lg hover:shadow-[#F2613F]/30
                           transition-all duration-300
                           flex items-center gap-2"
                    style="background-color: var(--site-accent, #F2613F);"
                >
                    Log in
                    <span class="arrow-hover">→</span>
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button
                id="mobile-menu-toggle"
                type="button"
                class="md:hidden relative w-10 h-10 flex items-center justify-center"
                aria-label="Menu"
                aria-expanded="false"
                aria-controls="mobile-menu-panel"
            >
                <span class="sr-only">Menu</span>
                <span data-menu-line="top" class="absolute block h-0.5 w-6 -translate-y-2 bg-gray-900 transition-all duration-300 ease-in-out"></span>
                <span data-menu-line="middle" class="absolute block h-0.5 w-6 bg-gray-900 transition-all duration-300 ease-in-out"></span>
                <span data-menu-line="bottom" class="absolute block h-0.5 w-6 translate-y-2 bg-gray-900 transition-all duration-300 ease-in-out"></span>
            </button>
        </div>

        <!-- Mobile menu -->
        <div
            id="mobile-menu-panel"
            class="absolute left-0 right-0 top-full z-50 hidden md:hidden border-t bg-white shadow-lg"
        >
            <div class="flex flex-col px-6 py-6 gap-5
                        font-bold text-[16px] leading-[22px]">
                <a href="#" class="text-gray-900">Home</a>

                <!-- Mobile Dropdown -->
                <div>
                    <button
                        class="flex justify-between w-full text-gray-900"
                    >
                        Namen voor je huisdieren
                        <svg
                            class="w-4 h-4 transition-transform duration-200"
                            :class="mobileDropdown ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        class="pl-4 mt-3 flex flex-col gap-3 font-normal text-[15px]"
                    >
                        <a href="#">Hondennamen</a>
                        <a href="#">Kattennamen</a>
                        <a href="#">Vogelnamen</a>
                    </div>
                </div>

                <a href="#" class="text-gray-900">Blog</a>
                <a href="#" class="text-gray-900">Contact</a>

                <a
                    href="#"
                    class="group mt-2 bg-[#F2613F] text-white text-center
                           font-bold text-[16px]
                           py-3 rounded-full
                           hover:bg-[#d94e2e] transition-all duration-300
                           flex items-center justify-center gap-2"
                    style="background-color: var(--site-accent, #F2613F);"
                >
                    Log in
                    <span class="arrow-hover">→</span>
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
(function () {
    var toggleButton = document.getElementById('mobile-menu-toggle');
    var panel = document.getElementById('mobile-menu-panel');

    if (!toggleButton || !panel) return;

    var topLine = toggleButton.querySelector('[data-menu-line="top"]');
    var middleLine = toggleButton.querySelector('[data-menu-line="middle"]');
    var bottomLine = toggleButton.querySelector('[data-menu-line="bottom"]');

    var closeMenu = function () {
        panel.classList.add('hidden');
        toggleButton.setAttribute('aria-expanded', 'false');
        topLine && topLine.classList.remove('translate-y-0', 'rotate-45');
        topLine && topLine.classList.add('-translate-y-2');
        middleLine && middleLine.classList.remove('opacity-0');
        bottomLine && bottomLine.classList.remove('translate-y-0', '-rotate-45');
        bottomLine && bottomLine.classList.add('translate-y-2');
    };

    var openMenu = function () {
        panel.classList.remove('hidden');
        toggleButton.setAttribute('aria-expanded', 'true');
        topLine && topLine.classList.remove('-translate-y-2');
        topLine && topLine.classList.add('translate-y-0', 'rotate-45');
        middleLine && middleLine.classList.add('opacity-0');
        bottomLine && bottomLine.classList.remove('translate-y-2');
        bottomLine && bottomLine.classList.add('translate-y-0', '-rotate-45');
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

    closeMenu();
})();
</script>

