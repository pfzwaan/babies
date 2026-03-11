@php
    $global = \App\Models\GlobalContent::singleton();

    $title = $data['title'] ?? null;
    $intro = $data['intro'] ?? null;

    $title = filled($title) ? $title : ($global->contact_forms_title ?: 'Contact');
    $intro = filled($intro) ? $intro : ($global->contact_forms_intro ?: 'Heb je een vraag over babynamen, suggesties voor onze content of wil je iets met ons delen? Stuur gerust een bericht. We proberen zo snel mogelijk te reageren.');
@endphp

<section class="relative overflow-hidden bg-[#FFF8EF] py-14 md:py-20">
    <div class="container relative mx-auto px-4 md:px-8">
        <div class="mx-auto max-w-[1120px]">
            <div class="flex items-center justify-center gap-4 lg:gap-8">
                <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[22px] w-[50px] lg:h-[34px] lg:w-[78px]" />
                <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="h-[44px] w-[48px] lg:h-[58px] lg:w-[64px]" />
                <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[22px] w-[50px] scale-x-[-1] lg:h-[34px] lg:w-[78px]" />
            </div>

            <div class="mt-6 text-center">
                <h2 class="text-[38px] font-bold leading-[1.02] text-[#353535] lg:text-[58px]" style="font-family:Outfit,sans-serif;">{{ $title }}</h2>
                <p class="mx-auto mt-5 max-w-[860px] text-[17px] leading-[1.85] text-[#4E4B46] lg:text-[20px]">
                    {{ $intro }}
                </p>
            </div>

            <div class="mt-12 grid gap-8 xl:grid-cols-[minmax(0,1fr)_340px] xl:items-start">
                <div class="rounded-[30px] bg-[#DDEDFE] p-5 sm:p-7 lg:p-8">
                    <div class="rounded-[26px] bg-white p-6 shadow-[0_18px_50px_rgba(51,78,112,0.08)] md:p-8">
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="mt-1 h-[30px] w-[36px]" />
                            <div>
                                <h3 class="text-[28px] font-bold leading-[1.05] text-[#353535] lg:text-[36px]" style="font-family:Outfit,sans-serif;">Stuur ons een bericht</h3>
                                <p class="mt-3 max-w-[620px] text-[15px] leading-[1.8] text-[#5B5B5B] lg:text-[16px]">Vul het formulier in en laat ons weten waar je hulp bij nodig hebt. Of het nu gaat om een naamvraag, een inhoudelijke correctie of een samenwerking: we lezen alles met aandacht.</p>
                            </div>
                        </div>

                        <form method="POST" action="#" class="mt-8 grid gap-5">
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

                            <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
                                <p class="max-w-[420px] text-[13px] leading-[1.7] text-[#7A7A7A]">Door dit formulier te versturen ga je akkoord met het verwerken van je bericht zodat wij contact met je kunnen opnemen.</p>
                                <button type="submit" class="inline-flex h-[56px] items-center justify-center rounded-full bg-[#FF7D97] px-9 text-[16px] font-semibold text-white transition hover:brightness-95">
                                    Verzenden
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-[30px] bg-[#F9E3BF] px-6 py-7">
                        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[28px] w-[34px]" />
                        <h3 class="mt-3 text-[28px] font-bold leading-[1.08] text-[#353535]" style="font-family:Outfit,sans-serif;">Contactinformatie</h3>
                        <div class="mt-6 space-y-5 text-[15px] leading-[1.8] text-[#4E4B46]">
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

                    <section class="relative overflow-hidden rounded-[30px] border border-[#E5E5E5] bg-[#FCE7EC] px-6 pb-8 pt-8">
                        <img src="{{ asset('img/babies/sidebar-banner-bg.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-45" />
                        <div class="relative z-10">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="h-[34px] w-[38px]" />
                                <p class="text-[14px] font-semibold uppercase tracking-[0.8px] text-[#8B5B66]">Babynamengids</p>
                            </div>
                            <h3 class="mt-4 text-[30px] font-bold leading-[1.1] text-[#353535]" style="font-family:Outfit,sans-serif;">Heb je naam-inspiratie nodig?</h3>
                            <p class="mt-4 text-[15px] leading-[1.8] text-[#4E4B46]">Bekijk onze populairste naamoverzichten en laat je inspireren door betekenissen, trends en originele suggesties.</p>
                            <a href="{{ url('/namen') }}" class="mt-6 inline-flex h-[54px] items-center justify-center rounded-full bg-[#FF7D97] px-8 text-[15px] font-semibold text-white">
                                Naar namenoverzicht
                            </a>
                            <img src="{{ asset('img/babies/sidebar-banner-products.png') }}" alt="" aria-hidden="true" class="mx-auto mt-5 h-auto w-full max-w-[250px]" />
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</section>
