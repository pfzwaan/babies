@php
    $global = \App\Models\GlobalContent::singleton(($site ?? null)?->id);

    $footerTitle1 = $global->footer_title_1 ?: 'Over Babynamengids.nl';
    $footerContent1 = $global->footer_content_1 ?: '<p>Onze site biedt duidelijke en nuttige informatie over de betekenis, oorsprong en trends van babynamen.</p>';

    $footerTitle2 = $global->footer_title_2 ?: 'Jongensnamen';
    $footerContent2 = $global->footerNavigation2?->toFooterHtml() ?: ($global->footer_content_2 ?: '<ul><li>&gt; Jongensnamen</li></ul>');

    $footerTitle3 = $global->footer_title_3 ?: 'Meisjesnamen';
    $footerContent3 = $global->footerNavigation3?->toFooterHtml() ?: ($global->footer_content_3 ?: '<ul><li>&gt; Meisjesnamen</li></ul>');

    $footerTitle4 = $global->footer_title_4 ?: 'Speciale namen';
    $footerContent4 = $global->footer_content_4 ?: '
        <ul>
            <li>&rsaquo; <a href="/jongensnamen/stoere">Stoere namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/korte">Korte namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/unieke">Unieke namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/ouderwetse">Ouderwetse namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/ouderwetse">Ouderwetse jongensnamen</a></li>
            <li>&rsaquo; <a href="/meisjesnamen/ouderwetse">Ouderwetse meisjesnamen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/klassieke">Klassieke namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/bijzondere">Bijzondere namen</a></li>
            <li>&rsaquo; <a href="/jongensnamen/betekenis-namen">Betekenis namen</a></li>
        </ul>';

    $footerSocialLabel = $global->footer_social_label ?: 'Volg ons via:';
    $facebookUrl = $global->footer_social_facebook_url;
    $instagramUrl = $global->footer_social_instagram_url;
@endphp

<footer class="relative bg-[#F9E3BF]">
    <div class="pointer-events-none absolute inset-x-0 -top-[31px] z-10 h-[32px] overflow-hidden">
        <div class="h-full w-full -scale-y-100 bg-[#F9E3BF]" style="-webkit-mask-image:url('{{ asset('img/babies/menu-wave.svg') }}');mask-image:url('{{ asset('img/babies/menu-wave.svg') }}');-webkit-mask-repeat:repeat-x;mask-repeat:repeat-x;-webkit-mask-position:bottom left;mask-position:bottom left;-webkit-mask-size:auto 32px;mask-size:auto 64px;"></div>
    </div>

    <div class="container mx-auto px-4 py-12 md:px-8 lg:py-[88px]">
        <div class="grid gap-10 lg:grid-cols-2 xl:grid-cols-[minmax(0,1.45fr)_repeat(3,minmax(0,1fr))] xl:gap-[40px]">
            <div>
                <img src="{{ asset('img/babies/logo.svg') }}" alt="Babynamengids" class="h-auto w-[266px]" />
                <div class="mt-8 text-[18px] font-light leading-[30px] text-black">
                    <span class="font-semibold">{{ $footerTitle1 }}</span><br /><br />
                    {!! $footerContent1 !!}
                </div>

                <p class="mt-8 text-[18px] font-semibold leading-[30px] text-black">{{ $footerSocialLabel }}</p>
                <div class="mt-2 flex items-center gap-3">
                    @if(filled($facebookUrl))
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/babies/footer-facebook.svg') }}" alt="Facebook" class="h-[26px] w-[27px]" /></a>
                    @endif
                    @if(filled($instagramUrl))
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/babies/footer-instagram.svg') }}" alt="Instagram" class="h-[26px] w-[27px]" /></a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-[20px] font-bold leading-[40px] text-black">{{ $footerTitle2 }}</h4>
                <div class="mt-2 space-y-1 text-[18px] leading-[40px] text-black">{!! $footerContent2 !!}</div>
            </div>

            <div>
                <h4 class="text-[20px] font-bold leading-[40px] text-black">{{ $footerTitle3 }}</h4>
                <div class="mt-2 space-y-1 text-[18px] leading-[40px] text-black">{!! $footerContent3 !!}</div>
            </div>

            <div>
                <h4 class="text-[20px] font-bold leading-[40px] text-black">{{ $footerTitle4 }}</h4>
                <div class="mt-2 space-y-1 text-[18px] leading-[40px] text-black">{!! $footerContent4 !!}</div>
            </div>
        </div>

        <div class="mt-10 border-t border-[#d8ba87] pt-4 text-[18px] font-light leading-[30px] text-black">
            &copy; 2006 - {{ now()->year }} Babynamengids.nl
        </div>
    </div>
</footer>


