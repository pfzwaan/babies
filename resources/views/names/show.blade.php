<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name->title }} - Dierennames</title>
    <meta name="description" content="Zoek hondennamen op basis van de beginletter.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900">
@include('pages.header')

<main class="mx-auto w-full max-w-container px-6 py-8">
    @php($nameInitial = strtoupper(substr((string) $name->title, 0, 1)))
    @php($nameLetter = preg_match('/^[A-Z]$/', $nameInitial) ? $nameInitial : 'A')
    @php($approvedComments = $approvedComments ?? collect())
    @php($ai = is_array($name->ai_content ?? null) ? $name->ai_content : [])
    @php($popularityTitle = $ai['popularity_title'] ?? "De populariteit van {$name->title}")
    @php($popularityText1 = $ai['popularity_text_1'] ?? "Hoewel {$name->title} niet een van de meest voorkomende namen ter wereld is, laat de naam de laatste jaren een interessante en groeiende trend zien. Dit maakt het een unieke, moderne en bijzondere keuze voor uw hond.")
    @php($popularityText2 = $ai['popularity_text_2'] ?? "Met naar schatting 281 keer gebruik in 2025 valt {$name->title} in de categorie van exclusieve namen, ideaal voor huisdieren met een sterke persoonlijkheid.")
    @php($trendTitle = $ai['trend_title'] ?? 'Populariteitstrend door de tijd heen')
    @php($trendText = $ai['trend_text'] ?? "In de Amerikaanse namenregisters begon {$name->title} rond 2005 voor te komen en sindsdien is de populariteit ervan gefluctueerd. De laatste jaren is er een stijgende trend te zien, met een piek in het gebruik rond het begin van de jaren 2020.")
    @php($originTitle = $ai['origin_title'] ?? 'Toelichting herkomst en betekenis')
    @php($originParagraphs = collect($ai['origin_paragraphs'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($originParagraphs = $originParagraphs->isNotEmpty() ? $originParagraphs : collect([
        "De naam {$name->title} vindt zijn oorsprong voornamelijk in het Oudengels en is afgeleid van het woord aesc, wat 'es' betekent. Deze boom is in verschillende culturen, waaronder de Noorse mythologie, een symbool geweest van kracht, veerkracht en bescherming.",
        "Bovendien kan {$name->title} ook worden gezien als een variant van de naam Ash of Asher. In moderne contexten wordt de naam geassocieerd met positieve betekenissen zoals 'gelukkig', 'gezegend' of 'fortuinlijk'.",
        "Voor een hond combineert deze naam natuur, kracht, gratie en een nobel karakter; ideaal als je een krachtige naam met een diepe betekenis wilt.",
    ]))
    @php($famousTitle = $ai['famous_title'] ?? "{$name->title} in de bekende personen")
    @php($famousIntro = $ai['famous_intro'] ?? "Hoewel de naam {$name->title} niet extreem bekend is in de popcultuur, is hij wel in verschillende vormen opgedoken:")
    @php($famousItems = collect($ai['famous_items'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($famousItems = $famousItems->isNotEmpty() ? $famousItems : collect([
        "{$name->title} (Ashlyn Rae Willson): Amerikaanse singer-songwriter, bekend van \"Moral of the Story\".",
        "{$name->title} - kampioen in League of Legends.",
        "{$name->title} - personage in Final Fantasy XII.",
        "Ash - protagonist van Pokemon (Ash Ketchum).",
    ]))
    @php($filmsTitle = $ai['films_title'] ?? 'Films en tv-series')
    @php($filmsText = $ai['films_text'] ?? "Hoewel {$name->title} als specifieke naam niet centraal staat in veel films, zijn varianten zoals Ash wel te vinden in populaire fictie.")
    @php($relatedTitle = $ai['related_title'] ?? 'Vergelijkbare namen met een vergelijkbare uitstraling')
    @php($relatedNames = collect($ai['related_names'] ?? [])->filter(fn ($item) => is_string($item) && trim($item) !== '')->values())
    @php($relatedNames = $relatedNames->isNotEmpty() ? $relatedNames : collect(['Ash', 'Ace', 'Arlo', 'Axe', 'Ashby', 'Ashwin', 'Asher', 'Axel']))
    @php($relatedChunks = $relatedNames->chunk((int) max(1, ceil($relatedNames->count() / 4))))
    <!-- from figma: 26787:1504 -->
    <p class="mb-6 text-sm text-ink md:text-[22px] md:leading-5">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        &gt;
        <a href="{{ route('names.archive') }}" class="hover:underline">Namen archief</a>
        &gt;
        <a href="{{ route('names.category', ['nameCategory' => $nameCategory]) }}" class="hover:underline">{{ $nameCategory->name }}</a>
        &gt;
        <a href="{{ route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => strtolower($nameLetter)]) }}" class="hover:underline">{{ $nameLetter }}</a>
        &gt;
        <span class="font-bold">{{ $name->title }}</span>
    </p>

    <!-- from figma: 26811:37 -->
    <section class="relative mb-10 overflow-hidden rounded-[30px] bg-ink md:rounded-[50px]">
        <div class="relative h-[220px] md:h-[267px]">
            <img src="{{ asset('img/figma/26811-27.svg') }}" alt="" aria-hidden="true" class="absolute right-6 top-0 hidden w-[220px] md:block" />
            <img src="{{ asset('img/figma/26811-32.svg') }}" alt="" aria-hidden="true" class="absolute bottom-0 left-5 hidden w-[220px] md:block" />
            <img src="{{ asset('img/figma/26811-25.svg') }}" alt="" aria-hidden="true" class="absolute left-20 top-8 hidden w-12 opacity-25 md:block md:w-[88px]" />
            <img src="{{ asset('img/figma/26811-36.svg') }}" alt="" aria-hidden="true" class="absolute bottom-2 right-24 hidden w-12 opacity-25 md:block md:w-[88px]" />
            <img src="{{ asset('img/figma/26811-23.svg') }}" alt="" aria-hidden="true" class="absolute right-0 bottom-0 hidden w-[220px] lg:block" />
            <div class="relative z-10 flex h-full items-center justify-center px-4 text-center">
                <!-- from figma: 26811:41 -->
                <h1 class="font-fredoka text-[40px] font-bold leading-tight text-green md:text-[70px] md:leading-[96px]">{{ $name->title }}</h1>
            </div>
            <img src="{{ asset('img/figma/26811-39.svg') }}" alt="" aria-hidden="true" class="absolute right-[36%] top-[18%] hidden w-[44px] md:block" />
        </div>
    </section>

    <!-- from figma: 26837:146 -->
    <section class="rounded-[30px] bg-panel p-6 md:p-12">
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- from figma: 26821:36 -->
            <article class="space-y-4">
                <h2 class="font-fredoka text-2xl font-semibold md:text-[32px]">{{ $popularityTitle }}</h2>
                <p class="text-[18px] leading-[35px]">
                    {{ $popularityText1 }}
                </p>
                <p class="text-[19px] leading-[35px]">{{ $popularityText2 }}</p>
            </article>

            <!-- from figma: 26822:39 -->
            <article class="space-y-4">
                <h2 class="font-fredoka text-2xl font-semibold md:text-[32px]">{{ $trendTitle }}</h2>
                <p class="text-[19px] leading-[35px]">
                    {{ $trendText }}
                </p>
            </article>
        </div>
    </section>

    <p
        id="name-like-feedback"
        class="mt-6 text-sm font-medium @if(session('name_like_status')) @else hidden @endif @if(session('name_like_status') === 'liked') text-green-700 @elseif(session('name_like_status') === 'already_liked') text-amber-700 @endif"
    >
        @if(session('name_like_status') === 'liked')
            Bedankt! Je like is opgeslagen.
        @elseif(session('name_like_status') === 'already_liked')
            Je hebt al eerder op deze naam gestemd.
        @endif
    </p>

    <!-- from figma: 26836:145 -->
    <section class="mt-9 grid gap-4 md:grid-cols-2">
        <form id="name-like-form" method="POST" action="{{ route('names.like', ['nameCategory' => $nameCategory, 'name' => $name]) }}">
            @csrf
            <button id="name-like-button" type="submit" class="flex h-[117px] w-full items-center justify-center gap-4 rounded-[20px] bg-ink text-white">
                <span class="text-[28px] font-bold">Like</span>
                <img src="{{ asset('img/figma/26836-133.svg') }}" alt="" aria-hidden="true" class="h-8 w-9" />
            </button>
            <p class="mt-2 text-center text-sm text-ink">Likes: <span id="name-likes-count">{{ number_format((int) ($name->likes_count ?? 0)) }}</span></p>
        </form>
        <button
            type="button"
            id="open-name-comment-modal"
            class="flex h-[117px] items-center justify-center gap-4 rounded-[20px] bg-panel text-ink"
        >
            <span class="text-[28px] font-bold">Comment</span>
            <img src="{{ asset('img/figma/26835-130.svg') }}" alt="" aria-hidden="true" class="h-[35px] w-[39px]" />
        </button>
    </section>
    <p class="mt-2 text-sm text-ink">Comments: {{ $approvedComments->count() }}</p>

    @if(session('comment_status') === 'pending')
        <p class="mt-4 text-sm font-medium text-green-700">Bedankt! Je reactie is ontvangen en wacht op goedkeuring van een beheerder.</p>
    @endif

    <!-- from figma: 26787:1403 -->
    <section class="mt-16 space-y-5">
        <h2 class="font-fredoka text-2xl font-medium md:text-[24px]">{{ $originTitle }}</h2>
        @foreach($originParagraphs as $originParagraph)
            <p class="text-[18px] leading-[35px]">{{ $originParagraph }}</p>
        @endforeach
    </section>

    <!-- from figma: 26837:199 -->
    <section class="mt-16 space-y-7 rounded-[30px] bg-panel p-8 md:p-12">
        <div class="space-y-3">
            <h3 class="font-fredoka text-2xl font-medium md:text-[24px]">{{ $famousTitle }}</h3>
            <p class="text-[18px] leading-[35px]">{{ $famousIntro }}</p>
        </div>
        <ul class="list-disc space-y-3 pl-6 text-[18px] leading-[35px]">
            @foreach($famousItems as $famousItem)
                <li>{{ $famousItem }}</li>
            @endforeach
        </ul>
        <div class="space-y-3">
            <h3 class="font-fredoka text-2xl font-medium md:text-[24px]">{{ $filmsTitle }}</h3>
            <p class="text-[18px] leading-[35px]">{{ $filmsText }}</p>
        </div>
    </section>

    <!-- from figma: 26837:264 -->
    <section class="mt-16 rounded-[30px] bg-ink p-6 md:p-10">
        <h3 class="mb-6 font-fredoka text-xl font-medium text-white md:text-[24px]">{{ $relatedTitle }}</h3>
        <div class="rounded-[30px] bg-white p-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($relatedChunks as $relatedChunk)
                    <ul class="space-y-4 text-[28px] leading-6">
                        @foreach($relatedChunk as $relatedName)
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-[39px] w-[39px] items-center justify-center rounded-full bg-ink">
                                    <img src="{{ asset('img/figma/26837-270.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[18px]" />
                                </span>
                                {{ $relatedName }}
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white" style="height: 100px;"></section>
</main>

<div id="name-comment-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/50 p-4" aria-hidden="true">
    <div class="w-full max-w-[900px] rounded-[24px] bg-white p-6 md:p-8 max-h-[90vh] overflow-y-auto">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="font-fredoka text-2xl font-semibold text-ink md:text-[32px]">Comment op {{ $name->title }}</h3>
            <button type="button" id="close-name-comment-modal" class="rounded-full bg-panel px-3 py-1 text-sm font-semibold text-ink">Sluiten</button>
        </div>

        <form method="POST" action="{{ route('names.comments.store', ['nameCategory' => $nameCategory, 'name' => $name]) }}" class="space-y-4 rounded-[20px] border border-[#E5E7EB] p-4 md:p-6">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="comment-author-name" class="mb-2 block text-sm font-semibold text-[#111827]">Naam</label>
                    <input id="comment-author-name" name="author_name" type="text" value="{{ old('author_name') }}" required class="h-[44px] w-full rounded-[10px] border border-[#d1d5db] px-3 text-[15px] text-[#111827] focus:border-[#F2643D] focus:outline-none" />
                    @error('author_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="comment-author-email" class="mb-2 block text-sm font-semibold text-[#111827]">E-mail</label>
                    <input id="comment-author-email" name="author_email" type="email" value="{{ old('author_email') }}" required class="h-[44px] w-full rounded-[10px] border border-[#d1d5db] px-3 text-[15px] text-[#111827] focus:border-[#F2643D] focus:outline-none" />
                    @error('author_email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="comment-message" class="mb-2 block text-sm font-semibold text-[#111827]">Bericht</label>
                <textarea id="comment-message" name="message" rows="5" required class="w-full rounded-[10px] border border-[#d1d5db] px-3 py-2 text-[15px] text-[#111827] focus:border-[#F2643D] focus:outline-none">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="inline-flex h-[44px] items-center justify-center rounded-[999px] bg-[#F2643D] px-8 text-[15px] font-semibold text-white transition hover:bg-[#E55630]">
                Plaats comment
            </button>
        </form>

        <div class="mt-8 space-y-4">
            <h4 class="font-fredoka text-xl font-semibold text-ink md:text-[26px]">Reacties</h4>
            @forelse($approvedComments as $comment)
                <article class="rounded-[16px] border border-[#E5E7EB] bg-white p-4">
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <p class="font-semibold text-ink">{{ $comment->author_name }}</p>
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

@include('pages.footer')
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

            if (likeForm.dataset.loading === '1') {
                return;
            }

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

                if (!response.ok) {
                    throw new Error('Request failed');
                }

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
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    @if($errors->has('author_name') || $errors->has('author_email') || $errors->has('message'))
        openModal();
    @endif
});
</script>
</body>
</html>
