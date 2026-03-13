@php
    $global = \App\Models\GlobalContent::singleton(($site ?? null)?->id);

    $title = $data['title'] ?? null;
    $intro = $data['intro'] ?? null;

    $title = filled($title) ? $title : ($global->contact_forms_title ?: 'Contact');
    $intro = filled($intro) ? $intro : ($global->contact_forms_intro ?: 'Heb je een vraag over babynamen, suggesties voor onze content of wil je iets met ons delen? Stuur gerust een bericht. We proberen zo snel mogelijk te reageren.');
@endphp

<section class="relative overflow-hidden bg-[#FFF8EF] py-10 md:py-20 lg:-mt-[30px]">
    <div class="container relative mx-auto px-4 md:px-8">
        <div class="mx-auto max-w-[1120px]">
            <div class="flex items-center justify-center gap-3 lg:gap-8">
                <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[42px] lg:h-[34px] lg:w-[78px]" />
                <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="h-[36px] w-[40px] lg:h-[58px] lg:w-[64px]" />
                <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[42px] scale-x-[-1] lg:h-[34px] lg:w-[78px]" />
            </div>

            <div class="mt-6 text-center">
                <h2 class="text-[34px] font-bold leading-[1.02] text-[#353535] lg:text-[58px]" style="font-family:Outfit,sans-serif;">{{ $title }}</h2>
                <p class="mx-auto mt-4 max-w-[860px] text-[15px] leading-[1.8] text-[#4E4B46] lg:mt-5 lg:text-[20px] lg:leading-[1.85]">
                    {{ $intro }}
                </p>
            </div>

            <div class="mt-10 grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px] xl:items-start xl:gap-8">
                <div class="rounded-[26px] bg-[#DDEDFE] p-3 sm:p-7 lg:p-8">
                    <div class="rounded-[22px] bg-white p-5 shadow-[0_18px_50px_rgba(51,78,112,0.08)] md:p-8">
                        <div class="flex items-start gap-3 md:gap-4">
                            <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="mt-1 h-[24px] w-[29px] md:h-[30px] md:w-[36px]" />
                            <div>
                                <h3 class="text-[24px] font-bold leading-[1.05] text-[#353535] md:text-[36px]" style="font-family:Outfit,sans-serif;">Stuur ons een bericht</h3>
                                <p class="mt-2 max-w-[620px] text-[14px] leading-[1.75] text-[#5B5B5B] md:mt-3 md:text-[16px] md:leading-[1.8]">Vul het formulier in en laat ons weten waar je hulp bij nodig hebt. Of het nu gaat om een naamvraag, een inhoudelijke correctie of een samenwerking: we lezen alles met aandacht.</p>
                            </div>
                        </div>

                        <form method="POST" action="#" class="mt-6 grid gap-4 md:mt-8 md:gap-5">
                            @csrf
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="contact-name" class="mb-2 block text-[15px] font-semibold text-[#353535]">Naam</label>
                                    <input id="contact-name" name="name" type="text" required class="h-[54px] w-full rounded-[14px] border border-[#DCE4EF] bg-[#FBFDFF] px-4 text-[16px] text-[#111827] shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] focus:border-[#FF7D97] focus:outline-none" />
                                </div>

                                <div>
                                    <label for="contact-subject" class="mb-2 block text-[15px] font-semibold text-[#353535]">Onderwerp</label>
                                    <input id="contact-subject" name="subject" type="text" required class="h-[54px] w-full rounded-[14px] border border-[#DCE4EF] bg-[#FBFDFF] px-4 text-[16px] text-[#111827] shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] focus:border-[#FF7D97] focus:outline-none" />
                                </div>
                            </div>

                            <div>
                                <label for="contact-message" class="mb-2 block text-[15px] font-semibold text-[#353535]">Bericht</label>
                                <textarea id="contact-message" name="message" rows="8" required class="w-full rounded-[18px] border border-[#DCE4EF] bg-[#FBFDFF] px-4 py-4 text-[16px] text-[#111827] shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] focus:border-[#FF7D97] focus:outline-none"></textarea>
                            </div>

                            <div class="flex flex-col gap-4 pt-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="max-w-[420px] text-[12px] leading-[1.65] text-[#7A7A7A] md:text-[13px] md:leading-[1.7]">Door dit formulier te versturen ga je akkoord met het verwerken van je bericht zodat wij contact met je kunnen opnemen.</p>
                                <button type="submit" class="inline-flex h-[52px] w-full items-center justify-center rounded-full bg-[#FF7D97] px-9 text-[15px] font-semibold text-white transition hover:brightness-95 sm:w-auto sm:min-w-[160px] sm:text-[16px]">
                                    Verzenden
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-[26px] bg-[#F9E3BF] px-5 py-6 md:px-6 md:py-7">
                        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[29px] md:h-[28px] md:w-[34px]" />
                        <h3 class="mt-3 text-[24px] font-bold leading-[1.08] text-[#353535] md:text-[28px]" style="font-family:Outfit,sans-serif;">Contactinformatie</h3>
                        <div class="mt-5 space-y-4 text-[14px] leading-[1.75] text-[#4E4B46] md:mt-6 md:space-y-5 md:text-[15px] md:leading-[1.8]">
                            <div>
                                <p class="font-semibold text-[#353535]">Reactietijd</p>
                                <p>We reageren meestal binnen 1 tot 2 werkdagen.</p>
                            </div>
                            <div>
                                <p class="font-semibold text-[#353535]">Samenwerkingen</p>
                                <p>Voor content, partnerships of vermeldingen kun je hetzelfde formulier gebruiken.</p>
                            </div>
                            <div>
                                <p class="font-semibold text-[#353535]">Inhoudelijke vragen</p>
                                <p>Zie je een fout of mis je een naam? Laat het ons weten, dan kijken we ernaar.</p>
                            </div>
                        </div>
                    </section>

                    <section class="relative overflow-hidden rounded-[26px] border border-[#E5E5E5] bg-[#FCE7EC] px-5 pb-6 pt-6 md:rounded-[30px] md:px-6 md:pb-8 md:pt-8">
                        <img src="{{ asset('img/babies/sidebar-banner-bg.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-45" />
                        <div class="relative z-10">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="h-[30px] w-[34px] md:h-[34px] md:w-[38px]" />
                                <p class="text-[14px] font-semibold uppercase tracking-[0.8px] text-[#8B5B66]">Babynamengids</p>
                            </div>
                            <h3 class="mt-3 text-[24px] font-bold leading-[1.08] text-[#353535] md:mt-4 md:text-[30px]" style="font-family:Outfit,sans-serif;">Heb je naam-inspiratie nodig?</h3>
                            <p class="mt-3 text-[14px] leading-[1.75] text-[#4E4B46] md:mt-4 md:text-[15px] md:leading-[1.8]">Bekijk onze populairste naamoverzichten en laat je inspireren door betekenissen, trends en originele suggesties.</p>
                            <a href="{{ url('/namen') }}" class="mt-5 inline-flex h-[50px] items-center justify-center rounded-full bg-[#FF7D97] px-7 text-[14px] font-semibold text-white md:mt-6 md:h-[54px] md:px-8 md:text-[15px]">
                                Naar namenoverzicht
                            </a>
                            <img src="{{ asset('img/babies/sidebar-banner-products.png') }}" alt="" aria-hidden="true" class="mx-auto mt-4 h-auto w-full max-w-[210px] md:mt-5 md:max-w-[250px]" />
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</section>
