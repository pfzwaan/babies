@php
    $introTitle = $data['intro_title'] ?? 'Vind de perfecte naam voor je huisdier';
    $introText = $data['intro_text'] ?? 'Het kiezen van de ideale naam voor een huisdier is een belangrijke beslissing. Een naam identificeert niet alleen je huisdier, maar weerspiegelt ook zijn of haar persoonlijkheid, stijl en de speciale band die jullie delen. Op deze site vind je een breed scala aan huisdiernamen, ontworpen om je te helpen de beste keuze te maken.';

    $sectionHeading = $data['section_heading'] ?? 'Namen voor honden en andere huisdieren';
    $sectionText = $data['section_text'] ?? 'Hondennamen zijn vaak populair, omdat honden het meest gekozen huisdier zijn. Toch verdienen ook andere huisdieren, zoals katten, konijnen, vogels en hamsters, aandacht bij het kiezen van een geschikte naam. Op deze site vind je top-10-lijsten, populaire lijsten en suggesties voor zowel mannelijke als vrouwelijke huisdieren.';

    $subheading1 = $data['subheading_1'] ?? 'Hoe kies je de beste naam voor je huisdier?';
    $subtext1 = $data['subtext_1'] ?? 'Het kiezen van een naam voor je huisdier hoeft niet ingewikkeld te zijn. Een goede naam moet makkelijk te onthouden zijn, prettig klinken en geschikt zijn voor het dier en de levensfase. Vermijd namen die te lang zijn of lijken op commando\'s.';

    $subheading2 = $data['subheading_2'] ?? 'Ideeen voor huisdiernamen, toplijsten en zoekmachine';
    $subtext2 = $data['subtext_2'] ?? 'Naast inspiratie en voorbeelden biedt onze site ook een zoekmachine voor huisdiernamen. Hiermee kun je filteren op diersoort, geslacht of persoonlijkheid. Zo vind je snel een naam die perfect past bij jouw huisdier.';

    $subheading3 = $data['subheading_3'] ?? 'Jouw vertrouwde plek voor huisdiernamen';
    $subtext3 = $data['subtext_3'] ?? 'Deze site is ontworpen om de bron te worden voor iedereen die op zoek is naar mooie, originele en populaire huisdiernamen. Of je nu een puppy, kitten, vogel of ander dier hebt geadopteerd, hier vind je ideeen die passen bij jouw huisdier.';
@endphp

<!-- content block -->
<section class="w-full bg-white py-[48px] md:py-[80px]">

    <div class="max-w-container mx-auto px-6">

        <!-- Intro title -->
        <h2 class="font-[Fredoka] font-semibold
                   text-[30px] leading-[40px]
                   text-[#111827] mb-[16px]">
            {{ $introTitle }}
        </h2>

        <!-- Intro text -->
        <p class="font-sans font-normal
                  text-[18px] leading-[32px]
                  text-[#111827] mb-[40px]">
            {{ $introText }}
        </p>

        <!-- Section heading -->
        <h3 class="font-[Fredoka] font-semibold
                   text-[30px] leading-[40px]
                   text-[#111827] mb-[16px]">
            {{ $sectionHeading }}
        </h3>

        <p class="font-sans font-normal
                  text-[18px] leading-[32px]
                  text-[#111827] mb-[40px]">
            {{ $sectionText }}
        </p>

        <!-- Sub heading -->
        <h3 class="font-[Fredoka] font-semibold
                   text-[30px] leading-[40px]
                   text-[#111827] mb-[12px]">
            {{ $subheading1 }}
        </h3>

        <p class="font-sans font-normal
                  text-[18px] leading-[32px]
                  text-[#111827] mb-[32px]">
            {{ $subtext1 }}
        </p>

        <!-- Sub heading -->
        <h3 class="font-[Fredoka] font-semibold
                   text-[30px] leading-[40px]
                   text-[#111827] mb-[12px]">
            {{ $subheading2 }}
        </h3>

        <p class="font-sans font-normal
                  text-[18px] leading-[32px]
                  text-[#111827] mb-[32px]">
            {{ $subtext2 }}
        </p>

        <!-- Sub heading -->
        <h3 class="font-[Fredoka] font-semibold
                   text-[30px] leading-[40px]
                   text-[#111827] mb-[12px]">
            {{ $subheading3 }}
        </h3>

        <p class="font-sans font-normal
                  text-[18px] leading-[32px]
                  text-[#111827]">
            {{ $subtext3 }}
        </p>

    </div>

</section>
