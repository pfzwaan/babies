<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Pagina niet gevonden</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/themes/default.css'])
    <style>
        .error-404-section { position: relative; overflow: hidden; padding: 220px 16px; min-height: 90vh; display: flex; align-items: center; }
        .error-404-bg { position: absolute; inset: 0; z-index: -1; background: linear-gradient(to bottom, #FFF7ED, #FFFFFF 55%, #FFFFFF 100%); }
        .error-404-wrap { max-width: 980px; margin: 0 auto; text-align: center; }
        .error-404-code { margin: 0; font-family: 'Fredoka', sans-serif; font-size: clamp(140px, 22vw, 320px); line-height: .95; font-weight: 700; color: #F2613F; }
        .error-404-title { margin: 20px 0 0; font-size: clamp(56px, 8vw, 112px); line-height: 1.05; font-weight: 700; color: #0F172A; }
        .error-404-description { max-width: 720px; margin: 24px auto 0; font-size: clamp(22px, 2.8vw, 36px); color: #475569; }
        .error-404-actions { margin-top: 58px; display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .error-404-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 16px 34px; font-size: 16px; font-weight: 600; text-decoration: none; transition: all .2s ease; }
        @media (max-width: 768px) {
            .error-404-section { padding: 150px 16px; min-height: 76vh; }
            .error-404-actions { flex-direction: column; align-items: center; }
            .error-404-btn { width: 100%; max-width: 280px; }
        }
    </style>
</head>
<body class="theme-default">
    @include('themes.default.pages.header')

    <main>
        <section class="error-404-section">
            <div class="error-404-bg"></div>
            <div class="error-404-wrap">
                <p class="error-404-code">404</p>
                <h1 class="error-404-title">Pagina niet gevonden</h1>
                <p class="error-404-description">De pagina die je zoekt bestaat niet meer of is verplaatst.</p>
                <div class="error-404-actions">
                    <a href="{{ url('/') }}" class="error-404-btn" style="background:#F2613F;color:#fff;">Terug naar home</a>
                    <a href="{{ route('names.archive') }}" class="error-404-btn" style="border:1px solid #CBD5E1;background:#fff;color:#1E293B;">Bekijk alle namen</a>
                </div>
            </div>
        </section>
    </main>

    @include('themes.default.pages.footer')
</body>
</html>
