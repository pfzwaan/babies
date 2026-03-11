@php
    $global = \App\Models\GlobalContent::singleton();

    $title = $data['title'] ?? null;
    $intro = $data['intro'] ?? null;

    $title = filled($title) ? $title : ($global->contact_forms_title ?: 'Contact');
    $intro = filled($intro) ? $intro : ($global->contact_forms_intro ?: null);
@endphp

<section class="mx-auto w-full max-w-[1200px] px-4 pt-12 pb-[100px] md:px-8">
    <h2 class="font-fredoka text-[32px] font-semibold leading-tight text-ink md:text-[44px]">{{ $title }}</h2>

    @if(filled($intro))
        <p class="mt-4 max-w-[900px] text-[18px] leading-[32px] text-[#4b5563] md:text-[20px] md:leading-[35px]">
            {{ $intro }}
        </p>
    @endif

    <div class="mt-8 rounded-[24px] border border-[#e5e7eb] bg-white p-6 shadow-sm md:p-8">
        <form method="POST" action="#" class="space-y-5">
            @csrf
            <div>
                <label for="contact-name" class="mb-2 block text-[15px] font-semibold text-[#111827]">Naam</label>
                <input
                    id="contact-name"
                    name="name"
                    type="text"
                    required
                    class="h-[48px] w-full rounded-[10px] border border-[#d1d5db] px-4 text-[16px] text-[#111827] focus:border-[#F2643D] focus:outline-none"
                />
            </div>

            <div>
                <label for="contact-subject" class="mb-2 block text-[15px] font-semibold text-[#111827]">Subject</label>
                <input
                    id="contact-subject"
                    name="subject"
                    type="text"
                    required
                    class="h-[48px] w-full rounded-[10px] border border-[#d1d5db] px-4 text-[16px] text-[#111827] focus:border-[#F2643D] focus:outline-none"
                />
            </div>

            <div>
                <label for="contact-message" class="mb-2 block text-[15px] font-semibold text-[#111827]">Bericht</label>
                <textarea
                    id="contact-message"
                    name="message"
                    rows="6"
                    required
                    class="w-full rounded-[10px] border border-[#d1d5db] px-4 py-3 text-[16px] text-[#111827] focus:border-[#F2643D] focus:outline-none"
                ></textarea>
            </div>

            <button
                type="submit"
                class="inline-flex h-[48px] items-center justify-center rounded-[999px] bg-[#F2643D] px-8 text-[16px] font-semibold text-white transition hover:bg-[#E55630]"
            >
                Verzenden
            </button>
        </form>
    </div>
</section>
