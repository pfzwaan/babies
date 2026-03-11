<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Pagina niet gevonden</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/themes/babies.css'])
</head>
<body class="theme-babies bg-white pt-[130px] text-[#353535] lg:pt-[200px]" style="font-family:Poppins,sans-serif;">
    @include('themes.babies.pages.header')

    <main>
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-[#FFF8ED] via-[#FDF6EC] to-white"></div>
            <div class="relative container mx-auto px-4 py-14 md:px-8 md:py-24">
                <div class="mx-auto max-w-[980px] rounded-[40px] border border-[#F0DAB3] bg-white/90 p-8 text-center shadow-[0_20px_60px_rgba(0,0,0,0.08)] md:p-14">
                    <p class="text-[120px] font-bold leading-[1] text-[#FF7D97] md:text-[180px]" style="font-family:Outfit,sans-serif;">404</p>
                    <h1 class="mt-2 text-[40px] font-bold leading-[1.05] text-[#353535] md:text-[64px]" style="font-family:Outfit,sans-serif;">Oops, pagina niet gevonden</h1>
                    <p class="mx-auto mt-5 max-w-[720px] text-[19px] leading-[32px] text-[#5a5a5a] md:text-[24px] md:leading-[38px]">
                        De pagina die je zoekt bestaat niet of is verplaatst. Kies hieronder waar je naartoe wilt.
                    </p>

                    <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ url('/') }}" class="inline-flex h-[60px] items-center justify-center rounded-full bg-[#FF7D97] px-10 text-[18px] font-semibold text-white transition hover:brightness-95">
                            Terug naar home
                        </a>
                        <a href="{{ route('names.archive') }}" class="inline-flex h-[60px] items-center justify-center rounded-full border border-[#D7D7D7] bg-white px-10 text-[18px] font-semibold text-[#353535] transition hover:bg-[#F9FAFB]">
                            Bekijk alle namen
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('themes.babies.pages.footer')
</body>
</html>


