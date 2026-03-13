<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name->title }} - Babynamengids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/themes/babies.css'])
</head>
<body class="bg-white pt-[130px] text-[#353535] lg:pt-[200px]" style="font-family:Poppins,sans-serif;">
@include('themes.babies.pages.header')

<main>
    @php($nameInitial = strtoupper(substr((string) $name->title, 0, 1)))
    @php($nameLetter = preg_match('/^[A-Z]$/', $nameInitial) ? $nameInitial : 'A')
    @php($approvedComments = $approvedComments ?? collect())
    @php($ai = is_array($name->ai_content ?? null) ? $name->ai_content : [])
    @php($meaning = $name->meaning ?: ($ai['meaning'] ?? 'Geen betekenis beschikbaar.'))
    @php($genderLabel = $name->gender === 'female' ? 'Meisjesnaam' : ($name->gender === 'male' ? 'Jongensnaam' : 'Unisex naam'))
    @php($popularityTitle = $ai['popularity_title'] ?? "De populariteit van {$name->title}")
    @php($popularityText1 = $ai['popularity_text_1'] ?? "De naam {$name->title} heeft een zachte, toegankelijke uitstraling en wordt vooral gekozen door ouders die houden van korte, herkenbare namen met karakter.")
    @php($popularityText2 = $ai['popularity_text_2'] ?? "{$name->title} is geen massale standaardnaam, maar juist een keuze die opvalt door eenvoud en eigenheid. Daardoor blijft de naam bijzonder zonder ingewikkeld te zijn.")
    @php($trendTitle = $ai['trend_title'] ?? "Populariteitstrend door de tijd heen")
    @php($trendText = $ai['trend_text'] ?? "Door de jaren heen laat {$name->title} een rustige maar duidelijke groei zien. De naam wint aan aantrekkingskracht doordat hij modern klinkt en tegelijk tijdloos aanvoelt.")
    @php($originTitle = $ai['origin_title'] ?? 'Toelichting herkomst en betekenis')
    @php($originParagraphs = collect($ai['origin_paragraphs'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($originParagraphs = $originParagraphs->isNotEmpty() ? $originParagraphs : collect([$ai['origin_text'] ?? "De naam {$name->title} heeft een toegankelijke klank en voelt vriendelijk, helder en eigentijds aan. Daardoor past hij goed bij ouders die zoeken naar een naam die eenvoudig oogt maar toch een eigen uitstraling heeft."]))
    @php($famousTitle = $ai['famous_title'] ?? "Bekende personen met de naam {$name->title}")
    @php($famousIntro = $ai['famous_intro'] ?? "Hoewel {$name->title} geen extreem veelvoorkomende naam is, komt hij wel terug in verschillende contexten en varianten. Dat geeft de naam extra herkenbaarheid zonder zijn unieke karakter te verliezen.")
    @php($famousItems = collect($ai['famous_items'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($filmsTitle = $ai['films_title'] ?? "Films en tv-series waarin de naam {$name->title} voorkomt")
    @php($filmsText = $ai['films_text'] ?? "Ook in fictie en populaire cultuur duiken vergelijkbare namen geregeld op. Daardoor voelt {$name->title} vertrouwd aan, terwijl de naam toch fris en onderscheidend blijft.")
    @php($relatedTitle = $ai['related_title'] ?? 'Vergelijkbare namen met een vergelijkbare uitstraling')
    @php($relatedNames = collect($ai['related_names'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($relatedNames = $relatedNames->isNotEmpty() ? $relatedNames : collect([$name->title, $name->title . 'a', $name->title . 'e', $name->title . 'ia', 'Noah', 'Liam', 'Nora', 'Sara']))
    @php($relatedChunks = $relatedNames->chunk((int) max(1, ceil($relatedNames->count() / 2))))
    @php($relatedIndex = 1)

    <section class="relative overflow-hidden bg-[#F7F1E8] lg:-mt-[30px]">
        <div class="absolute inset-0 bg-black/10"></div>
        <img src="{{ asset('img/babies/single-hero-image.svg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover" />
        <img src="{{ asset('img/babies/single-hero-layer.svg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover opacity-80" />
        <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="absolute left-[7%] top-[18%] hidden h-[54px] w-[59px] lg:block" />
        <img src="{{ asset('img/babies/single-part1-center-shape.svg') }}" alt="" aria-hidden="true" class="absolute right-[10%] top-[16%] hidden h-[70px] w-[78px] rotate-[6deg] lg:block" />
        <img src="{{ asset('img/babies/single-part1-star-cluster.svg') }}" alt="" aria-hidden="true" class="absolute left-[9%] bottom-[18%] hidden h-[54px] w-[61px] lg:block" />
        <div class="relative container mx-auto flex h-[220px] items-center justify-center px-4 text-center sm:h-[260px] lg:h-[320px]">
            <h1 class="text-[40px] font-bold leading-none text-white drop-shadow-[0_3px_10px_rgba(0,0,0,0.2)] sm:text-[56px] lg:text-[61px]" style="font-family:Outfit,sans-serif;">{{ $name->title }}</h1>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20 pt-6 md:px-8 lg:pb-24">
        <nav class="text-[12px] font-medium uppercase tracking-[0.4px] text-[#8E867D] sm:text-[13px]">
            <a href="{{ url('/') }}">Home</a>
            <span class="px-2">&gt;</span>
            <a href="{{ route('names.archive') }}">Namen archief</a>
            <span class="px-2">&gt;</span>
            <a href="{{ route('names.category', ['nameCategory' => $nameCategory]) }}">{{ $nameCategory->name }}</a>
            <span class="px-2">&gt;</span>
            <a href="{{ route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => strtolower($nameLetter)]) }}">{{ $nameLetter }}</a>
            <span class="px-2">&gt;</span>
            <span class="font-semibold text-[#353535]">{{ $name->title }}</span>
        </nav>

        <section class="mx-auto mt-7 max-w-[1120px]">
            <div class="grid grid-cols-[1fr_auto_1fr] items-center">
                <div class="flex justify-start">
                    <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[22px] w-[50px] lg:h-[34px] lg:w-[78px]" />
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('img/babies/seo-sun.svg') }}" alt="" aria-hidden="true" class="h-[44px] w-[48px] lg:h-[58px] lg:w-[64px]" />
                </div>
                <div class="flex justify-end">
                    <img src="{{ asset('img/babies/blog-title-stars.svg') }}" alt="" aria-hidden="true" class="h-[22px] w-[50px] scale-x-[-1] lg:h-[34px] lg:w-[78px]" />
                </div>
            </div>

            <article class="mt-7 rounded-[24px] bg-[#DDEDFE] p-5 sm:p-7 lg:p-[34px]">
                <div class="grid overflow-hidden rounded-[18px] bg-[#DDEDFE] lg:grid-cols-2">
                    <div class="p-5 lg:px-7 lg:py-6">
                        <h3 class="text-[24px] font-bold leading-[1.1] text-[#353535] lg:text-[34px]" style="font-family:Outfit,sans-serif;">Betekenis van de naam {{ $name->title }}</h3>
                        <p class="mt-5 text-[15px] leading-[1.8] text-[#4B4B4B] lg:text-[16px]">{{ $meaning }}</p>
                    </div>
                    <div class="p-5 lg:px-7 lg:py-6">
                        <h3 class="text-[24px] font-bold leading-[1.1] text-[#353535] lg:text-[34px]" style="font-family:Outfit,sans-serif;">Geslacht:</h3>
                        <div class="mt-5 flex items-center gap-3">
                            <img src="{{ asset('img/babies/single-part1-gender-icon.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[28px] shrink-0 lg:h-[32px] lg:w-[38px]" />
                            <p class="text-[15px] leading-[1.8] text-[#4B4B4B] lg:text-[16px]">{{ $genderLabel }}</p>
                        </div>
                    </div>
                    <div class="p-5 lg:px-7 lg:py-6">
                        <h3 class="text-[24px] font-bold leading-[1.1] text-[#353535] lg:text-[34px]" style="font-family:Outfit,sans-serif;">Oorsprong van de naam:</h3>
                        <p class="mt-5 text-[15px] leading-[1.8] text-[#4B4B4B] lg:text-[16px]">{{ $ai['origin_summary'] ?? 'Informatie over de oorsprong van deze naam is momenteel niet volledig beschikbaar.' }}</p>
                    </div>
                    <div class="p-5 lg:px-7 lg:py-6">
                        <h3 class="text-[24px] font-bold leading-[1.1] text-[#353535] lg:text-[34px]" style="font-family:Outfit,sans-serif;">Oorsprong van de naam:</h3>
                        <p class="mt-5 text-[15px] leading-[1.8] text-[#4B4B4B] lg:text-[16px]">{{ $trendText }}</p>
                    </div>
                </div>
            </article>

            <section class="mt-10 grid gap-10 lg:grid-cols-[minmax(0,1fr)_394px] lg:items-start">
                <article>
                    <h3 class="text-[18px] font-semibold text-[#353535] lg:text-[19px]">{{ $popularityTitle }}</h3>
                    <p class="mt-4 text-[15px] leading-[1.9] text-[#4B4B4B] lg:text-[16px]">{{ $popularityText1 }}</p>
                    <p class="mt-4 text-[15px] leading-[1.9] text-[#4B4B4B] lg:text-[16px]">{{ $popularityText2 }}</p>
                </article>

                <article>
                    <h3 class="text-[14px] font-semibold text-[#353535]">{{ $trendTitle }}</h3>
                    <div class="mt-4 rounded-[16px] border border-[#E8EEF6] bg-white p-4 shadow-[0_12px_30px_rgba(28,56,94,0.08)]">
                        <img src="{{ asset('img/babies/single-part1-chart.svg') }}" alt="" aria-hidden="true" class="h-auto w-full" />
                    </div>
                </article>
            </section>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <form id="name-like-form" method="POST" action="{{ route('names.like', ['nameCategory' => $nameCategory, 'name' => $name]) }}">
                    @csrf
                    <button id="name-like-button" type="submit" class="flex h-[56px] w-full items-center justify-center gap-3 rounded-[10px] bg-[#64A7E9] px-5 text-[15px] font-semibold text-[#353535]">
                        <span>Like</span>
                        <img src="{{ asset('img/babies/single-part1-like-icon.svg') }}" alt="" aria-hidden="true" class="h-[19px] w-[21px]" />
                    </button>
                    <p class="mt-2 text-center text-[12px] text-[#7B7B7B]">Likes: <span id="name-likes-count">{{ number_format((int) ($name->likes_count ?? 0)) }}</span></p>
                </form>

                <button type="button" class="flex h-[56px] items-center justify-center gap-3 rounded-[10px] bg-[#F1F4F7] px-5 text-[15px] font-semibold text-[#353535]" disabled>
                    <span>Opslaan</span>
                    <img src="{{ asset('img/babies/single-part1-save-icon.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[18px]" />
                </button>

                <button id="open-name-comment-modal" type="button" class="flex h-[56px] items-center justify-center gap-3 rounded-[10px] bg-[#F1F4F7] px-5 text-[15px] font-semibold text-[#353535]">
                    <span>Comment</span>
                    <img src="{{ asset('img/babies/single-part1-comment-icon.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[20px]" />
                </button>
            </div>

            <p
                id="name-like-feedback"
                class="mt-4 text-sm font-medium @if(session('name_like_status')) @else hidden @endif @if(session('name_like_status') === 'liked') text-green-700 @elseif(session('name_like_status') === 'already_liked') text-amber-700 @endif"
            >
                @if(session('name_like_status') === 'liked')
                    Bedankt! Je like is opgeslagen.
                @elseif(session('name_like_status') === 'already_liked')
                    Je hebt al eerder op deze naam gestemd.
                @endif
            </p>
            <p class="mt-2 text-sm text-[#7B7B7B]">Comments: {{ $approvedComments->count() }}</p>

            @if(session('comment_status') === 'pending')
                <p class="mt-4 text-sm font-medium text-green-700">Bedankt! Je reactie is ontvangen en wacht op goedkeuring van een beheerder.</p>
            @endif

            <section class="mt-16">
                <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[29px]" />
                <h2 class="mt-2 text-[30px] font-bold leading-[1.1] text-[#353535] lg:text-[42px]" style="font-family:Outfit,sans-serif;">{{ $originTitle }}</h2>
                <div class="mt-5 space-y-5 text-[16px] leading-[1.95] text-[#4B4B4B]">
                    @foreach($originParagraphs as $originParagraph)
                        <p>{{ $originParagraph }}</p>
                    @endforeach
                </div>
            </section>

            <section class="mt-14">
                <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[29px]" />
                <h2 class="mt-2 text-[30px] font-bold leading-[1.1] text-[#353535] lg:text-[42px]" style="font-family:Outfit,sans-serif;">{{ $famousTitle }}</h2>
                <p class="mt-5 text-[16px] leading-[1.95] text-[#4B4B4B]">{{ $famousIntro }}</p>
                @if($famousItems->isNotEmpty())
                    <ul class="mt-5 space-y-3 text-[16px] leading-[1.85] text-[#4B4B4B]">
                        @foreach($famousItems as $famousItem)
                            <li class="flex items-start gap-3">
                                <span class="mt-[10px] h-[6px] w-[6px] rounded-full bg-[#EFBA1D]"></span>
                                <span>{{ $famousItem }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section class="mt-14">
                <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[29px]" />
                <h2 class="mt-2 text-[30px] font-bold leading-[1.1] text-[#353535] lg:text-[42px]" style="font-family:Outfit,sans-serif;">{{ $filmsTitle }}</h2>
                <p class="mt-5 text-[16px] leading-[1.95] text-[#4B4B4B]">{{ $filmsText }}</p>
            </section>

            <section class="mt-14">
                <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="h-[24px] w-[29px]" />
                <h2 class="mt-2 text-[30px] font-bold leading-[1.1] text-[#353535] lg:text-[42px]" style="font-family:Outfit,sans-serif;">{{ $relatedTitle }}</h2>
                <div class="mt-5 rounded-[16px] border-[5px] border-[#64A7E9] bg-white p-5 sm:p-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach($relatedChunks as $relatedChunk)
                            <ul class="space-y-3 text-[15px] font-medium text-[#353535] lg:text-[18px]">
                                @foreach($relatedChunk as $relatedName)
                                    <li class="flex items-center gap-3">
                                        <span class="inline-flex h-[39px] w-[39px] items-center justify-center rounded-full bg-[rgba(100,167,233,0.35)] text-[#64A7E9]">
                                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-[18px] w-[20px]">
                                                <path d="M4.62732 0.0231372C0.10863 -0.403283 -1.0276 5.16335 0.899619 8.56081C3.25074 12.7045 7.95735 16.4913 12.2226 17.9096C12.3755 17.9606 12.5328 18.0116 12.6902 17.9977C12.913 17.9745 13.101 17.8308 13.2801 17.6918C16.042 15.5133 18.5024 12.7879 19.5469 9.1819C20.3073 6.98955 20.2592 3.84701 18.2402 2.41943C15.5657 0.532986 12.6945 3.4484 11.9036 6.04864C11.5889 4.7184 10.5095 3.77749 9.70102 2.75315C8.59975 1.35802 6.55891 0.213173 4.62732 0.0277732V0.0231372Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                        <span>{{ $relatedIndex }}. {{ $relatedName }}</span>
                                    </li>
                                    @php($relatedIndex++)
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </section>
        </section>
    </div>
</main>

<div id="name-comment-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/50 p-4" aria-hidden="true">
    <div class="max-h-[90vh] w-full max-w-[900px] overflow-y-auto rounded-[24px] bg-white p-6 md:p-8">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-[#353535] md:text-[32px]" style="font-family:Outfit,sans-serif;">Comment op {{ $name->title }}</h3>
            <button type="button" id="close-name-comment-modal" class="rounded-full bg-[#f1f7fd] px-3 py-1 text-sm font-semibold text-[#353535]">Sluiten</button>
        </div>

        <form method="POST" action="{{ route('names.comments.store', ['nameCategory' => $nameCategory, 'name' => $name]) }}" class="space-y-4 rounded-[20px] border border-[#E5E7EB] p-4 md:p-6">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="comment-author-name" class="mb-2 block text-sm font-semibold text-[#111827]">Naam</label>
                    <input id="comment-author-name" name="author_name" type="text" value="{{ old('author_name') }}" required class="h-[44px] w-full rounded-[10px] border border-[#d1d5db] px-3 text-[15px] text-[#111827] focus:border-[#FF7D97] focus:outline-none" />
                    @error('author_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="comment-author-email" class="mb-2 block text-sm font-semibold text-[#111827]">E-mail</label>
                    <input id="comment-author-email" name="author_email" type="email" value="{{ old('author_email') }}" required class="h-[44px] w-full rounded-[10px] border border-[#d1d5db] px-3 text-[15px] text-[#111827] focus:border-[#FF7D97] focus:outline-none" />
                    @error('author_email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="comment-message" class="mb-2 block text-sm font-semibold text-[#111827]">Bericht</label>
                <textarea id="comment-message" name="message" rows="5" required class="w-full rounded-[10px] border border-[#d1d5db] px-3 py-2 text-[15px] text-[#111827] focus:border-[#FF7D97] focus:outline-none">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="inline-flex h-[44px] items-center justify-center rounded-[999px] bg-[#FF7D97] px-8 text-[15px] font-semibold text-white transition hover:brightness-95">Plaats comment</button>
        </form>

        <div class="mt-8 space-y-4">
            <h4 class="text-xl font-semibold text-[#353535] md:text-[26px]" style="font-family:Outfit,sans-serif;">Reacties</h4>
            @forelse($approvedComments as $comment)
                <article class="rounded-[16px] border border-[#E5E7EB] bg-white p-4">
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <p class="font-semibold text-[#353535]">{{ $comment->author_name }}</p>
                        <p class="text-xs text-[#6B7280]">{{ optional($comment->created_at)->format('d-m-Y H:i') }}</p>
                    </div>
                    <p class="text-[15px] leading-[24px] text-[#374151]">{{ $comment->message }}</p>
                </article>
            @empty
                <p class="text-[15px] text-[#6B7280]">Nog geen goedgekeurde reacties.</p>
            @endforelse
        </div>
    </div>
</div>

@include('themes.babies.pages.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeForm = document.getElementById('name-like-form');
    const likeButton = document.getElementById('name-like-button');
    const likesCount = document.getElementById('name-likes-count');
    const likeFeedback = document.getElementById('name-like-feedback');

    const setLikeFeedback = function (status) {
        if (!likeFeedback) return;

        likeFeedback.classList.remove('hidden', 'text-green-700', 'text-amber-700', 'text-red-700');

        if (status === 'liked') {
            likeFeedback.textContent = 'Bedankt! Je like is opgeslagen.';
            likeFeedback.classList.add('text-green-700');
            return;
        }

        if (status === 'already_liked') {
            likeFeedback.textContent = 'Je hebt al eerder op deze naam gestemd.';
            likeFeedback.classList.add('text-amber-700');
            return;
        }

        likeFeedback.textContent = 'Er ging iets mis. Probeer het opnieuw.';
        likeFeedback.classList.add('text-red-700');
    };

    if (likeForm) {
        likeForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            if (likeForm.dataset.loading === '1') return;

            likeForm.dataset.loading = '1';
            if (likeButton) likeButton.disabled = true;

            try {
                const response = await fetch(likeForm.action, {
                    method: 'POST',
                    body: new FormData(likeForm),
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) throw new Error('Request failed');

                const data = await response.json();
                if (likesCount && typeof data.likes_count === 'number') {
                    likesCount.textContent = new Intl.NumberFormat('nl-NL').format(data.likes_count);
                }

                setLikeFeedback(data.status);
            } catch (error) {
                likeForm.submit();
            } finally {
                likeForm.dataset.loading = '0';
                if (likeButton) likeButton.disabled = false;
            }
        });
    }

    const openBtn = document.getElementById('open-name-comment-modal');
    const closeBtn = document.getElementById('close-name-comment-modal');
    const modal = document.getElementById('name-comment-modal');

    if (!modal) return;

    const openModal = function () {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
    };

    const closeModal = function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
    };

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    @if($errors->has('author_name') || $errors->has('author_email') || $errors->has('message'))
        openModal();
    @endif
});
</script>
</body>
</html>
