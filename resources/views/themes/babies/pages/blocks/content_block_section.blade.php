@php
    $sections = [
        [
            'title' => $data['intro_title'] ?? 'Meer over mooie en originele babynamen',
            'text' => $data['intro_text'] ?? 'Op Babynamengids.nl vind je een uitgebreide verzameling mooie en originele babynamen voor jongens en meisjes. Van klassieke namen tot moderne en unieke keuzes: wij helpen je inspiratie op te doen voor een naam die perfect past bij jouw baby. Ontdek de betekenis, herkomst en populariteit van elke babynaam en maak een weloverwogen keuze.',
        ],
        [
            'title' => $data['section_heading'] ?? 'Geschiedenis van babynamen',
            'text' => $data['section_text'] ?? 'Babynamen hebben een rijke geschiedenis die vaak teruggaat tot oude culturen, religies en tradities. In deze sectie lees je meer over de oorsprong en evolutie van babynamen door de eeuwen heen. Ontdek hoe namen zijn beÃ¯nvloed door taal, cultuur en maatschappelijke veranderingen en waarom sommige namen generaties lang populair blijven.',
        ],
        [
            'title' => $data['subheading_1'] ?? 'Nederlandse en buitenlandse namen',
            'text' => $data['subtext_1'] ?? 'Ben je op zoek naar Nederlandse babynamen of juist naar mooie buitenlandse namen? Bij Babynamengids.nl vind je een uitgebreide selectie namen uit Nederland en de rest van de wereld. Van traditionele Nederlandse namen tot internationale en exotische babynamen, allemaal overzichtelijk verzameld met betekenis en herkomst.',
        ],
        [
            'title' => $data['subheading_2'] ?? 'Babynamen per cultuur en afkomst',
            'text' => $data['subtext_2'] ?? 'Babynamen vertellen veel over cultuur en afkomst. In deze sectie ontdek je namen uit verschillende culturen, zoals Europese, Aziatische, Afrikaanse en Latijnse babynamen. Leer meer over hun betekenis en achtergrond.',
        ],
        [
            'title' => $data['subheading_3'] ?? 'Originele babynaam kiezen: tips & tricks',
            'text' => $data['subtext_3'] ?? 'Het kiezen van een originele naam voor je baby is een bijzondere beslissing. Om dit proces te vergemakkelijken, volg je deze stappen en vind je een unieke, mooie en betekenisvolle naam.',
            'tips' => [
                ['title' => 'Stap 1: Bepaal je naamstijl', 'text' => 'Denk vooraf na over het type naam dat je mooi vindt: modern, klassiek, kort, internationaal of uniek.'],
                ['title' => 'Stap 2: Onderzoek de betekenis', 'text' => 'Controleer de herkomst en betekenis zodat de naam echt past bij jullie waarden.'],
                ['title' => 'Stap 3: Controleer uitspraak en spelling', 'text' => 'Kies bij voorkeur een naam die makkelijk uit te spreken en te schrijven is.'],
                ['title' => 'Stap 4: Combineer met de achternaam', 'text' => 'Spreek de volledige naam hardop uit en test hoe het ritme en de klank aanvoelen.'],
                ['title' => 'Stap 5: Vermijd vluchtige trends', 'text' => 'Kies liever een tijdloze naam die ook op lange termijn mooi blijft.'],
                ['title' => 'Stap 6: Laat je inspireren door culturen', 'text' => 'Internationale namen kunnen unieke en betekenisvolle opties bieden.'],
                ['title' => 'Stap 7: Vertrouw op je intuÃ¯tie', 'text' => 'Ga uiteindelijk voor de naam die goed voelt en bij je baby past.'],
            ],
        ],
    ];
@endphp

<section class="babies-seo">
    <div class="container mx-auto">
        <div class="babies-seo__stack">
            @foreach ($sections as $section)
                <article class="babies-seo__item">
                    <div class="babies-seo__title-row">
                        <img src="{{ asset('img/babies/seo-crown.svg') }}" alt="" aria-hidden="true" class="babies-seo__crown" />
                        <h2>{{ $section['title'] }}</h2>
                    </div>
                    <p>{!! nl2br(e((string) $section['text'])) !!}</p>
                    @if(! empty($section['tips']) && is_array($section['tips']))
                        <ol class="babies-seo__tips">
                            @foreach($section['tips'] as $tip)
                                <li>
                                    <div class="babies-seo__tip-content">
                                        <strong>{{ $tip['title'] ?? '' }}</strong>
                                        <span>{{ $tip['text'] ?? '' }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>


