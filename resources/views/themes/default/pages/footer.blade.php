<!-- Main footer -->
@php
    $global = \App\Models\GlobalContent::singleton(($site ?? null)?->id);
    $footerTitle1 = $global->footer_title_1 ?: 'Over Dierennamengids.nl';
    $footerContent1 = $global->footer_content_1 ?: '<p>Welkom op de website vol met dierennamen! Dierennamengids.nl is de meest complete website in Nederland voor wat betreft dierennamen. Of je nu zoekt naar namen voor een hond of konijn. Dierennamengids.nl heeft voor ieder wat wils!</p>';
    $footerTitle2 = $global->footer_title_2 ?: 'Menu';
    $footerContent2 = $global->footerNavigation2?->toFooterHtml()
        ?: ($global->footer_content_2 ?: '<ul><li>&rsaquo; Home</li><li>&rsaquo; Hondennamen</li><li>&rsaquo; Hondennamen reu</li><li>&rsaquo; Hondennamen teefje</li><li>&rsaquo; Kattennamen</li><li>&rsaquo; Paardennamen</li><li>&rsaquo; Kippennamen</li><li>&rsaquo; Konijnennamen</li><li>&rsaquo; Cavia namen</li><li>&rsaquo; Hamsternamen</li><li>&rsaquo; Vissennamen</li><li>&rsaquo; Vogelnamen</li></ul>');
    $footerTitle3 = $global->footer_title_3 ?: 'Handige links';
    $footerContent3 = $global->footerNavigation3?->toFooterHtml()
        ?: ($global->footer_content_3 ?: '<ul><li>&rsaquo; Privacy Policy</li><li>&rsaquo; Disclaimer</li><li>&rsaquo; Over ons</li><li>&rsaquo; Adverteren</li><li>&rsaquo; Interessant</li></ul>');
    $footerTitle4 = $global->footer_title_4 ?: 'Vragen?';
    $footerContent4 = $global->footer_content_4 ?: '<p>Bel ons gerust als u vragen heeft</p><p><span style="color:#84CC16;">Ma - Vr :</span> 09.00 - 16.00</p><p><span style="color:#84CC16;">Weekend :</span> Gesloten</p>';
    $footerSocialLabel = $global->footer_social_label ?: 'Volg ons via:';
    $footerSocialLinks = collect([
        ['label' => 'Facebook', 'icon' => 'facebook', 'url' => $global->footer_social_facebook_url],
        ['label' => 'Instagram', 'icon' => 'instagram', 'url' => $global->footer_social_instagram_url],
        ['label' => 'TikTok', 'icon' => 'tiktok', 'url' => $global->footer_social_tiktok_url],
        ['label' => 'YouTube', 'icon' => 'youtube', 'url' => $global->footer_social_youtube_url],
    ])->filter(fn ($item) => filled($item['url']))->values();
@endphp
<footer class="theme-footer relative w-full text-white -mt-[40px] md:-mt-[80px]">
    <div class="absolute top-0 left-0 w-full">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-[60px] md:h-[120px]">
            <path id="footer-wave-fill" fill="#FFFFFF" d="
                    M0,70
                    C120,110 240,20 360,40
                    C480,60 600,120 720,90
                    C840,60 960,20 1080,40
                    C1200,60 1320,100 1440,70
                    L1440,0
                    L0,0
                    Z
                "></path>
        </svg>
    </div>
    <div class="max-w-container mx-auto px-6 pt-[80px] md:pt-[160px] pb-[48px] md:pb-[64px]">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-[32px] md:gap-[48px]">

            <!-- About -->
            <div>
                <div class="flex items-center gap-[10px] mb-[16px]">
                    <img src="{{ asset('img/logo.png') }}" class="h-[36px]" alt="">
                </div>

                <h4 class="font-semibold mb-[12px]">
                    {{ $footerTitle1 }}
                </h4>

                <div class="space-y-[10px] text-[15px] leading-[26px] text-[#CBD5E1]">
                    {!! $footerContent1 !!}
                </div>

                <div class="flex items-center gap-[12px] mt-[16px]">
                    <span class="text-[#CBD5E1]">{{ $footerSocialLabel }}</span>
                    @if($footerSocialLinks->isNotEmpty())
                        @foreach($footerSocialLinks as $social)
                            <a
                                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#334155] text-[#84CC16] hover:bg-[#475569] transition"
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ $social['label'] }}"
                            >
                                @if($social['icon'] === 'facebook')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                                        <path d="M22 12.07C22 6.49 17.52 2 12 2S2 6.49 2 12.07c0 5.02 3.66 9.18 8.44 9.93v-7.03H7.9v-2.9h2.54V9.86c0-2.52 1.49-3.91 3.78-3.91 1.09 0 2.24.2 2.24.2v2.47h-1.26c-1.24 0-1.62.77-1.62 1.56v1.88h2.76l-.44 2.9h-2.32V22c4.78-.75 8.44-4.91 8.44-9.93z"/>
                                    </svg>
                                @elseif($social['icon'] === 'instagram')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                                        <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.8A3.95 3.95 0 0 0 3.8 7.75v8.5a3.95 3.95 0 0 0 3.95 3.95h8.5a3.95 3.95 0 0 0 3.95-3.95v-8.5a3.95 3.95 0 0 0-3.95-3.95h-8.5zM12 7.2A4.8 4.8 0 1 1 7.2 12 4.81 4.81 0 0 1 12 7.2zm0 1.8A3 3 0 1 0 15 12a3 3 0 0 0-3-3zm5.1-2.27a1.14 1.14 0 1 1-1.14 1.14 1.14 1.14 0 0 1 1.14-1.14z"/>
                                    </svg>
                                @elseif($social['icon'] === 'tiktok')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                                        <path d="M14.5 2h2.67a4.8 4.8 0 0 0 3.44 3.44V8.1a7.45 7.45 0 0 1-3.44-.93v6.2a5.87 5.87 0 1 1-5.1-5.82v2.72a3.16 3.16 0 1 0 2.43 3.1V2z"/>
                                    </svg>
                                @elseif($social['icon'] === 'youtube')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                                        <path d="M23.5 7.1a3.02 3.02 0 0 0-2.12-2.13C19.52 4.5 12 4.5 12 4.5s-7.52 0-9.38.47A3.02 3.02 0 0 0 .5 7.1 31.9 31.9 0 0 0 0 12a31.9 31.9 0 0 0 .5 4.9 3.02 3.02 0 0 0 2.12 2.13C4.48 19.5 12 19.5 12 19.5s7.52 0 9.38-.47a3.02 3.02 0 0 0 2.12-2.13A31.9 31.9 0 0 0 24 12a31.9 31.9 0 0 0-.5-4.9zM9.75 15.5v-7L16 12l-6.25 3.5z"/>
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    @else
                        <a class="text-[#84CC16] text-lg" href="#">f</a>
                        <a class="text-[#84CC16] text-lg" href="#">o</a>
                    @endif
                </div>
            </div>

            <!-- Menu -->
            <div>
                <h4 class="font-[Fredoka] font-semibold text-[#84CC16] mb-[16px]">
                    {{ $footerTitle2 }}
                </h4>
                <div class="space-y-[10px] text-[15px] text-[#CBD5E1]">
                    {!! $footerContent2 !!}
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="font-[Fredoka] font-semibold text-[#84CC16] mb-[16px]">
                    {{ $footerTitle3 }}
                </h4>
                <div class="space-y-[10px] text-[15px] text-[#CBD5E1]">
                    {!! $footerContent3 !!}
                </div>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-[Fredoka] font-semibold text-[#84CC16] mb-[16px]">
                    {{ $footerTitle4 }}
                </h4>
                <div class="space-y-[10px] text-[15px] leading-[26px] text-[#CBD5E1]">
                    {!! $footerContent4 !!}
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom bar -->
    <div class="border-t border-white/10">
        <div class="max-w-container mx-auto px-6 py-[16px] text-[14px] text-[#CBD5E1]">
            Copyright 2008 - {{ now()->year }}
            <span class="text-[#84CC16] font-semibold">
                Dierennamengids.nl
            </span>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var wave = document.getElementById('footer-wave-fill');
    if (!wave) return;

    var fallback = window.getComputedStyle(document.body).backgroundColor || '#FFFFFF';
    var sections = document.querySelectorAll('main section');
    var background = '';

    for (var i = sections.length - 1; i >= 0; i--) {
        var color = window.getComputedStyle(sections[i]).backgroundColor;
        if (color && color !== 'transparent' && color !== 'rgba(0, 0, 0, 0)') {
            background = color;
            break;
        }
    }

    wave.setAttribute('fill', background || fallback);
});
</script>
