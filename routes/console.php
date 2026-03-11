<?php

use App\Models\Name;
use App\Models\Page;
use Awcodes\Curator\Models\Media;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('page:import-home-from-template', function () {
    $templateImageDir = base_path('plain-templates/img');

    if (! File::isDirectory($templateImageDir)) {
        $this->error("No se encontro la carpeta de imagenes: {$templateImageDir}");

        return 1;
    }

    $importImage = function (string $filename, ?string $alt = null) use ($templateImageDir): ?int {
        $sourcePath = $templateImageDir . DIRECTORY_SEPARATOR . $filename;

        if (! File::exists($sourcePath)) {
            $this->warn("Imagen no encontrada, se omite: {$filename}");

            return null;
        }

        $targetDirectory = 'home-import';
        $targetPath = $targetDirectory . '/' . $filename;
        $disk = Storage::disk('public');

        // Keep the imported file synced in the public disk used by Curator.
        $disk->put($targetPath, File::get($sourcePath));

        $imageSize = @getimagesize($sourcePath) ?: [null, null];
        $width = $imageSize[0] ?? null;
        $height = $imageSize[1] ?? null;

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $nameOnly = pathinfo($filename, PATHINFO_FILENAME);
        $prettyName = Str::of($nameOnly)
            ->replace(['-', '_'], ' ')
            ->title()
            ->value();

        $media = Media::query()->firstOrNew([
            'disk' => 'public',
            'path' => $targetPath,
        ]);

        $media->fill([
            'directory' => $targetDirectory,
            'visibility' => 'public',
            'name' => $nameOnly,
            'width' => $width,
            'height' => $height,
            'size' => File::size($sourcePath),
            'type' => File::mimeType($sourcePath) ?: 'application/octet-stream',
            'ext' => $extension,
            'alt' => $alt,
            'title' => $prettyName,
            'pretty_name' => $prettyName,
        ]);

        if (! $media->exists || $media->isDirty()) {
            $media->save();
        }

        return $media->getKey();
    };

    $mediaIds = [
        'hero_background' => $importImage('bg.png', 'Hero background'),
        'hero_shape' => $importImage('shape.png', 'Hero shape'),
        'animal_hond' => $importImage('hond.png', 'Hondennamen'),
        'animal_kat' => $importImage('kat.png', 'Kattennamen'),
        'animal_paard' => $importImage('paard.png', 'Paardennamen'),
        'animal_konijn' => $importImage('konijn.png', 'Konijnennamen'),
        'animal_vis' => $importImage('vis.png', 'Vissennamen'),
        'animal_vogel' => $importImage('vogel.png', 'Vogelnamen'),
        'animal_cavia' => $importImage('cavia.png', 'Cavianamen'),
        'animal_kip' => $importImage('kip.png', 'Kippennamen'),
        'animal_hamster' => $importImage('hamster.png', 'Hamsternamen'),
        'blog_featured' => $importImage('image24.png', 'Featured blog image'),
        'blog_card_1' => $importImage('pic2.png', 'Blog card 1'),
        'blog_card_2' => $importImage('pic3.png', 'Blog card 2'),
        'blog_card_3' => $importImage('pic4.png', 'Blog card 3'),
    ];

    $alphabet = [];

    foreach (range('A', 'Z') as $letter) {
        $alphabet[] = [
            'label' => $letter,
            'url' => '#',
        ];
    }

    $content = [
        [
            'type' => 'hero_section',
            'data' => [
                'background_image' => $mediaIds['hero_background'],
                'shape_image' => $mediaIds['hero_shape'],
                'title_prefix' => 'Vind de perfecte',
                'title_highlight' => 'naam',
                'title_suffix' => 'voor je huisdier',
                'subtitle' => 'Pas je zoekopdracht aan en ontdek duizenden namen voor honden, katten, vogels, vissen en meer.',
            ],
        ],
        [
            'type' => 'animal_blocks',
            'data' => [
                'cards' => [
                    ['title' => 'Hondennamen', 'description' => 'Bekijk snel onze hondennamen voor uw reu of teefje.', 'button_label' => 'Alle hondennamen', 'url' => '#', 'icon' => $mediaIds['animal_hond']],
                    ['title' => 'Kattennamen', 'description' => 'Bekijk snel onze kattennamen voor uw kater of poes.', 'button_label' => 'Alle kattennamen', 'url' => '#', 'icon' => $mediaIds['animal_kat']],
                    ['title' => 'Paardennamen', 'description' => 'Bekijk snel onze paardennamen.', 'button_label' => 'Alle paardennamen', 'url' => '#', 'icon' => $mediaIds['animal_paard']],
                    ['title' => 'Konijnennamen', 'description' => 'Bekijk snel onze konijnennamen.', 'button_label' => 'Alle konijnennamen', 'url' => '#', 'icon' => $mediaIds['animal_konijn']],
                    ['title' => 'Vissennamen', 'description' => 'Bekijk snel onze visnamen.', 'button_label' => 'Alle visnamen', 'url' => '#', 'icon' => $mediaIds['animal_vis']],
                    ['title' => 'Vogelnamen', 'description' => 'Bekijk snel onze vogelnamen.', 'button_label' => 'Alle vogelnamen', 'url' => '#', 'icon' => $mediaIds['animal_vogel']],
                    ['title' => 'Cavianamen', 'description' => 'Bekijk snel onze cavianamen.', 'button_label' => 'Alle cavianamen', 'url' => '#', 'icon' => $mediaIds['animal_cavia']],
                    ['title' => 'Kippennamen', 'description' => 'Bekijk snel onze kippennamen.', 'button_label' => 'Alle kippennamen', 'url' => '#', 'icon' => $mediaIds['animal_kip']],
                    ['title' => 'Hamsternamen', 'description' => 'Bekijk snel onze hamsternamen.', 'button_label' => 'Alle hamsternamen', 'url' => '#', 'icon' => $mediaIds['animal_hamster']],
                ],
            ],
        ],
        [
            'type' => 'blogs_section',
            'data' => [
                'heading_highlight' => 'Meer dan een naam:',
                'heading_text' => 'Blog en tips voor het kiezen van de ideale naam',
                'featured_image' => $mediaIds['blog_featured'],
                'featured_title' => 'Veelgemaakte fouten bij het kiezen van een naam voor een hond of kat.',
                'featured_excerpt' => 'Een van de meest voorkomende fouten bij het kiezen van een huisdiernaam is het kiezen van een naam die te lang of te ingewikkeld is. Dit kan het moeilijk maken voor het huisdier om de naam te leren en er correct op te reageren. Een andere veelgemaakte fout is het constant veranderen van de naam.',
                'featured_button_label' => 'Lees meer',
                'featured_url' => '#',
                'featured_tags' => '#fouten bij het kiezen van huisdiernamen #hondennamen #kattennamen',
                'cards' => [
                    ['image' => $mediaIds['blog_card_1'], 'title' => 'Hoe kies je de perfecte naam voor je huisdier?', 'excerpt' => 'Het kiezen van de perfecte naam voor je huisdier is een van de eerste beslissingen...', 'button_label' => 'Lees meer', 'url' => '#'],
                    ['image' => $mediaIds['blog_card_2'], 'title' => 'Is een korte of lange naam beter voor een huisdier?', 'excerpt' => 'Korte namen zijn meestal de beste optie voor de meeste huisdieren.', 'button_label' => 'Lees meer', 'url' => '#'],
                    ['image' => $mediaIds['blog_card_3'], 'title' => 'Ideeen en tips ter inspiratie bij het kiezen van een naam', 'excerpt' => 'Weet je niet welke naam je moet kiezen? Er zijn talloze inspiratiebronnen.', 'button_label' => 'Lees meer', 'url' => '#'],
                ],
                'cta_label' => 'Bekijk alle blogposts',
                'cta_url' => '#',
            ],
        ],
        [
            'type' => 'top_10_section',
            'data' => [
                'left_title' => "Top 10 namen voor mannelijke\nen vrouwelijke honden",
                'left_items' => [
                    ['name' => 'Max'],
                    ['name' => 'Buddy'],
                    ['name' => 'Joep'],
                    ['name' => 'Ollie'],
                    ['name' => 'Guus'],
                    ['name' => 'Luna'],
                    ['name' => 'Bella'],
                    ['name' => 'Pip'],
                    ['name' => 'Nala'],
                    ['name' => 'Lola'],
                ],
                'right_title' => "Top 10 originele namen\nvoor katten",
                'right_items' => [
                    ['name' => 'Simba'],
                    ['name' => 'Max'],
                    ['name' => 'Tommy'],
                    ['name' => 'Charlie'],
                    ['name' => 'Mickey'],
                    ['name' => 'Guus'],
                    ['name' => 'Gizmo'],
                    ['name' => 'Tijger'],
                    ['name' => 'Binky'],
                    ['name' => 'Toby'],
                ],
            ],
        ],
        [
            'type' => 'new_names_section',
            'data' => [
                'title' => 'Nieuwe namen toegevoegd in 2026',
                'items' => [
                    ['name' => 'Uraia', 'category' => 'Hondennamen'],
                    ['name' => 'Vlekje', 'category' => 'Hondennamen'],
                    ['name' => 'Femke', 'category' => 'Cavionamen'],
                    ['name' => 'Katra', 'category' => 'Vissennamen'],
                    ['name' => 'Ash', 'category' => 'Paardennamen'],
                    ['name' => 'Cindy', 'category' => 'Kattennamen'],
                    ['name' => 'Katra', 'category' => 'Kattennamen'],
                    ['name' => 'Femke', 'category' => 'Cavionamen'],
                ],
            ],
        ],
        [
            'type' => 'content_block_section',
            'data' => [
                'intro_title' => 'Vind de perfecte naam voor je huisdier',
                'intro_text' => 'Het kiezen van de ideale naam voor een huisdier is een belangrijke beslissing. Een naam identificeert niet alleen je huisdier, maar weerspiegelt ook zijn of haar persoonlijkheid, stijl en de speciale band die jullie delen. Op deze site vind je een breed scala aan huisdiernamen, ontworpen om je te helpen de beste keuze te maken.',
                'section_heading' => 'Namen voor honden en andere huisdieren',
                'section_text' => 'Hondennamen zijn vaak populair, omdat honden het meest gekozen huisdier zijn. Toch verdienen ook andere huisdieren, zoals katten, konijnen, vogels en hamsters, aandacht bij het kiezen van een geschikte naam. Op deze site vind je top-10-lijsten, populaire lijsten en suggesties voor zowel mannelijke als vrouwelijke huisdieren.',
                'subheading_1' => 'Hoe kies je de beste naam voor je huisdier?',
                'subtext_1' => 'Het kiezen van een naam voor je huisdier hoeft niet ingewikkeld te zijn. Een goede naam moet makkelijk te onthouden zijn, prettig klinken en geschikt zijn voor het dier en de levensfase. Vermijd namen die te lang zijn of lijken op commando\'s.',
                'subheading_2' => 'Ideeen voor huisdiernamen, toplijsten en zoekmachine',
                'subtext_2' => 'Naast inspiratie en voorbeelden biedt onze site ook een zoekmachine voor huisdiernamen. Hiermee kun je filteren op diersoort, geslacht of persoonlijkheid. Zo vind je snel een naam die perfect past bij jouw huisdier.',
                'subheading_3' => 'Jouw vertrouwde plek voor huisdiernamen',
                'subtext_3' => 'Deze site is ontworpen om de bron te worden voor iedereen die op zoek is naar mooie, originele en populaire huisdiernamen. Of je nu een puppy, kitten, vogel of ander dier hebt geadopteerd, hier vind je ideeen die passen bij jouw huisdier.',
            ],
        ],
        [
            'type' => 'alphabet_section',
            'data' => [
                'title' => 'Namen op alfabet',
                'letters' => $alphabet,
            ],
        ],
    ];

    $page = Page::query()->updateOrCreate(
        ['slug' => 'home'],
        [
            'title' => 'Home',
            'status' => 'published',
            'content' => $content,
        ]
    );

    $this->info("Pagina '{$page->slug}' importada/actualizada correctamente.");
    $this->line('Bloques cargados: ' . count($content));
    $this->line('Imagenes procesadas: ' . count($mediaIds));

    return 0;
})->purpose('Importa la Home desde plain-templates/index.php usando bloques del builder y Curator');

Artisan::command('names:import-babies', function () {
    $targetSiteId = 2;
    $maleCategoryId = 1;
    $femaleCategoryId = 2;
    $sourceDatabase = 'babies_db';

    $tables = [
        ['table' => 'af_jongens', 'lang' => 'af', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'en_jongens', 'lang' => 'en', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'frs_jongens', 'lang' => 'frs', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'gr_jongens', 'lang' => 'gr', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'it_jongens', 'lang' => 'it', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'nl_jongens', 'lang' => 'nl', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'sp_jongens', 'lang' => 'sp', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'be_jongens', 'lang' => 'be', 'gender' => 'male', 'category_id' => $maleCategoryId],
        ['table' => 'af_meisjes', 'lang' => 'af', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'en_meisjes', 'lang' => 'en', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'frs_meisjes', 'lang' => 'frs', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'gr_meisjes', 'lang' => 'gr', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'it_meisjes', 'lang' => 'it', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'nl_meisjes', 'lang' => 'nl', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'sp_meisjes', 'lang' => 'sp', 'gender' => 'female', 'category_id' => $femaleCategoryId],
        ['table' => 'be_meisjes', 'lang' => 'be', 'gender' => 'female', 'category_id' => $femaleCategoryId],
    ];

    if (! DB::table('sites')->where('id', $targetSiteId)->exists()) {
        $this->error("No existe el site_id={$targetSiteId}.");

        return 1;
    }

    if (! DB::table('name_categories')->where('id', $maleCategoryId)->exists() || ! DB::table('name_categories')->where('id', $femaleCategoryId)->exists()) {
        $this->error('No existen las categorias Male/Female esperadas.');

        return 1;
    }

    $connectionName = 'babies_import';
    config([
        "database.connections.{$connectionName}" => [
            'driver' => config('database.default'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $sourceDatabase,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'latin1',
            'collation' => 'latin1_swedish_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],
    ]);

    DB::purge($connectionName);
    $source = DB::connection($connectionName);

    $existingKeys = DB::table('names')
        ->where('site_id', $targetSiteId)
        ->whereIn('name_category_id', [$maleCategoryId, $femaleCategoryId])
        ->get(['title', 'gender', 'lang'])
        ->mapWithKeys(fn ($row) => [Str::lower(trim("{$row->lang}|{$row->gender}|{$row->title}")) => true])
        ->all();

    $usedSlugs = DB::table('names')
        ->whereNotNull('slug')
        ->pluck('slug')
        ->flip()
        ->all();

    $makeSlug = function (string $title) use (&$usedSlugs): string {
        $base = Str::slug($title);
        $base = $base !== '' ? $base : 'name';
        $slug = $base;
        $counter = 2;

        while (isset($usedSlugs[$slug])) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        $usedSlugs[$slug] = true;

        return $slug;
    };

    $normalizeTitle = function (string $title): string {
        $value = trim($title);

        if ($value !== '' && ! mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252');
        }

        return preg_replace('/\s+/u', ' ', trim($value)) ?? trim($value);
    };

    $totalInserted = 0;

    foreach ($tables as $definition) {
        $rows = $source->table($definition['table'])
            ->select('naam')
            ->whereNotNull('naam')
            ->whereRaw('TRIM(naam) <> ""')
            ->orderBy('id')
            ->get();

        $batch = [];
        $insertedForTable = 0;
        $seenInTable = [];

        foreach ($rows as $row) {
            $title = $normalizeTitle((string) $row->naam);

            if ($title === '') {
                continue;
            }

            $identityKey = Str::lower(trim("{$definition['lang']}|{$definition['gender']}|{$title}"));

            if (isset($existingKeys[$identityKey]) || isset($seenInTable[$identityKey])) {
                continue;
            }

            $seenInTable[$identityKey] = true;
            $existingKeys[$identityKey] = true;

            $batch[] = [
                'site_id' => $targetSiteId,
                'lang' => $definition['lang'],
                'title' => $title,
                'slug' => $makeSlug($title),
                'gender' => $definition['gender'],
                'name_category_id' => $definition['category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) === 1000) {
                DB::table('names')->insert($batch);
                $insertedForTable += count($batch);
                $totalInserted += count($batch);
                $batch = [];
            }
        }

        if ($batch !== []) {
            DB::table('names')->insert($batch);
            $insertedForTable += count($batch);
            $totalInserted += count($batch);
        }

        $this->line("{$definition['table']}: {$insertedForTable} importados");
    }

    $this->info("Importacion completada. Total insertados: {$totalInserted}");

    return 0;
})->purpose('Importa nombres desde babies_db al site Babies con lang, gender y slug unico');

Artisan::command('names:repair-babies-question-marks', function () {
    $siteId = 2;

    $replacements = [
        '?lvaro' => 'Álvaro',
        '?ngela' => 'Ángela',
        '?ngelita' => 'Ángelita',
        '?scar' => 'Óscar',
        'Aar?n' => 'Aarón',
        'Abra?m' => 'Abraím',
        'Abrah?n' => 'Abrahán',
        'Ad?n' => 'Adán',
        'Adri?n' => 'Adrián',
        'Agust?n' => 'Agustín',
        'Andr?s' => 'Andrés',
        'Ang?lica' => 'Angélica',
        'Anunciaci?n' => 'Anunciación',
        'Ascenci?n' => 'Ascención',
        'Asunci?n' => 'Asunción',
        'Bartolom?' => 'Bartolomé',
        'Bel?n' => 'Belén',
        'Beltr?n' => 'Beltrán',
        'Bereng?ria' => 'Berengària',
        'Bol?var' => 'Bolívar',
        'C?sar' => 'César',
        'Cebri?n' => 'Cebrián',
        'Cl?maco' => 'Clímaco',
        'Concepci?n' => 'Concepción',
        'Coraz?n' => 'Corazón',
        'Crist?bal' => 'Cristóbal',
        'Cristi?n' => 'Cristián',
        'D?bora' => 'Débora',
        'Dami?n' => 'Damián',
        'Efra?n' => 'Efraín',
        'Encarnaci?n' => 'Encarnación',
        'Espiridi?n' => 'Espiridión',
        'Est?ban' => 'Estéban',
        'Estefan?a' => 'Estefanía',
        'Euf?mia' => 'Eufémia',
        'Eug?nia' => 'Eugénia',
        'Eug?nio' => 'Eugénio',
        'Eul?lia' => 'Eulália',
        'Eul?lio' => 'Eulálio',
        'Fabi?n' => 'Fabián',
        'Ferm?n' => 'Fermín',
        'Fern?n' => 'Fernán',
        'Fern?nda' => 'Fernánda',
        'Fern?ndo' => 'Fernándo',
        'Germ?n' => 'Germán',
        'H?ctor' => 'Héctor',
        'Hern?n' => 'Hernán',
        'I?es' => 'Inés',
        'I?igo' => 'Íñigo',
        'I?jgo' => 'Íñigo',
        'In?z' => 'Inéz',
        'Jer?nimo' => 'Jerónimo',
        'Jes?s' => 'Jesús',
        'Jes?sa' => 'Jesusa',
        'Jos?' => 'José',
        'Juli?n' => 'Julián',
        'Jun?pero' => 'Junípero',
        'Le?n' => 'León',
        'Lo?da' => 'Loïda',
        'Luc?a' => 'Lucía',
        'M?nica' => 'Mónica',
        'M?ximo' => 'Máximo',
        'Mar?a' => 'María',
        'Mart?n' => 'Martín',
        'Merl?n' => 'Merlín',
        'Mois?s' => 'Moisés',
        'N?ria' => 'Núria',
        'Nicol?s' => 'Nicolás',
        'P?a' => 'Pía',
        'P?o' => 'Pío',
        'Pl?cido' => 'Plácido',
        'R?gulo' => 'Régulo',
        'Ra?l' => 'Raúl',
        'Ram?n' => 'Ramón',
        'Roc?o' => 'Rocío',
        'Rold?n' => 'Roldán',
        'Rom?n' => 'Román',
        'Rub?n' => 'Rubén',
        'Salom?n' => 'Salomón',
        'Sebasti?n' => 'Sebastián',
        'Sim?n' => 'Simón',
        'Sof?a' => 'Sofía',
        'Te?dulo' => 'Teódulo',
        'Te?fila' => 'Teófila',
        'Te?filo' => 'Teófilo',
        'To?o' => 'Toño',
        'Tom?s' => 'Tomás',
        'Trist?n' => 'Tristán',
        'V?ctor' => 'Víctor',
        'Valent?n' => 'Valentín',
        'Vencesl?s' => 'Venceslás',
        'Ver?nica' => 'Verónica',
        'Visitaci?n' => 'Visitación',
        'Zacar?as' => 'Zacarías',
        '?mer' => 'Ömer',
        '?veys' => 'Üveys',
        '?zge' => 'Özge',
        '?zcan' => 'Özcan',
        '?zer' => 'Özer',
        '?zg?r' => 'Özgür',
        '?zkan' => 'Özkan',
        'A?cha' => 'Aïcha',
        'A?da' => 'Aïda',
        'A?ron' => 'Aäron',
        'A?sha' => 'Aïsha',
        'A?ssa' => 'Aïssa',
        'A?ssata' => 'Aïssata',
        'A?ssatou' => 'Aïssatou',
        'Abiga?l' => 'Abigaïl',
        'Abiga?lle' => 'Abigaëlle',
        'Abyga?l' => 'Abygaïl',
        'Abyga?lle' => 'Abygaëlle',
        'Ad?la?de' => 'Adélaïde',
        'Ad?le' => 'Adèle',
        'Ad?lia' => 'Adélia',
        'Adela?de' => 'Adelaïde',
        'Agn?s' => 'Agnès',
        'Aim?' => 'Aimé',
        'Aim?e' => 'Aimée',
        'Aliz?' => 'Alizé',
        'Aliz?e' => 'Alizée',
        'Alo?s' => 'Aloïs',
        'Am?lia' => 'Amélia',
        'Am?lie' => 'Amélie',
        'Am?line' => 'Améline',
        'Ana?s' => 'Anaïs',
        'Andr?' => 'André',
        'Andr?a' => 'Andréa',
        'Andr?as' => 'Andréas',
        'Ang?le' => 'Angèle',
        'Ang?line' => 'Angéline',
        'Ang?lique' => 'Angélique',
        'Anna?lle' => 'Annaëlle',
        'Anne-Ga?lle' => 'Anne-Gaëlle',
        'Anth?a' => 'Anthéa',
        'Ath?na' => 'Athéna',
        'Aur?lia' => 'Aurélia',
        'Aur?lie' => 'Aurélie',
        'Aur?lien' => 'Aurélien',
        'Ayb?ke' => 'Aybüke',
        'Ayseg?l' => 'Aysegül',
        'B?atrice' => 'Béatrice',
        'B?n?dicte' => 'Bénédicte',
        'B?r?nice' => 'Bérénice',
        'Beg?m' => 'Begüm',
        'Beng?' => 'Bengü',
        'Bet?l' => 'Betül',
        'Beno?t' => 'Benoît',
        'Bj?rn' => 'Björn',
        'C?cile' => 'Cécile',
        'C?cilia' => 'Cécilia',
        'C?dric' => 'Cédric',
        'C?leste' => 'Céleste',
        'C?lia' => 'Célia',
        'C?lian' => 'Célian',
        'C?liane' => 'Céliane',
        'C?line' => 'Céline',
        'C?me' => 'Côme',
        'Cam?lia' => 'Camélia',
        'Cath?rine' => 'Cathérine',
        'Ch?ima' => 'Chaïma',
        'Cha?ma' => 'Chaïma',
        'Cha?mae' => 'Chaïmae',
        'Charl?ne' => 'Charlène',
        'Chim?ne' => 'Chimène',
        'Chlo?' => 'Chloé',
        'Cl?a' => 'Cléa',
        'Cl?lia' => 'Clélia',
        'Cl?mence' => 'Clémence',
        'Cl?ment' => 'Clément',
        'Cl?mentine' => 'Clémentine',
        'Clo?' => 'Cloé',
        'D?borah' => 'Déborah',
        'D?lia' => 'Délia',
        'D?sir?' => 'Désiré',
        'D?sir?e' => 'Désirée',
        'Daphn?' => 'Daphné',
        'Daphn?e' => 'Daphnée',
        'Dou?a' => 'Douâa',
        'El?a' => 'Eléa',
        'El?ana' => 'Eléana',
        'El?ane' => 'Eléane',
        'El?na' => 'Eléna',
        'El?ne' => 'Elène',
        'Elo?se' => 'Eloïse',
        'Em?lie' => 'Émilie',
        'Esm?' => 'Esmé',
        'Esm?e' => 'Esmée',
        'Eug?ne' => 'Eugène',
        'Eug?nie' => 'Eugénie',
        'Evang?line' => 'Evangéline',
        'Eyl?l' => 'Eylül',
        'F?bio' => 'Fábio',
        'F?e' => 'Fée',
        'F?lix' => 'Félix',
        'Fr?d?ric' => 'Frédéric',
        'Fr?d?rique' => 'Frédérique',
        'Fr?derique' => 'Frédérique',
        'Fran?ois' => 'François',
        'Fran?oise' => 'Françoise',
        'G?khan' => 'Gökhan',
        'G?kdeniz' => 'Gökdeniz',
        'G?l' => 'Gül',
        'G?lay' => 'Gülay',
        'G?ler' => 'Güler',
        'G?ls?m' => 'Gülsüm',
        'G?n?l' => 'Gönül',
        'G?raldine' => 'Géraldine',
        'G?rkan' => 'Gürkan',
        'G?rkem' => 'Görkem',
        'G?ven' => 'Güven',
        'Ga?l' => 'Gaël',
        'Ga?lle' => 'Gaëlle',
        'Ga?tan' => 'Gaétan',
        'Ga?tane' => 'Gaëtane',
        'Gabri?l' => 'Gabriël',
        'Gabri?lle' => 'Gabriëlle',
        'Gis?le' => 'Gisèle',
        'Gr?ce' => 'Grâce',
        'Gwena?lle' => 'Gwenaëlle',
        'Gwenna?lle' => 'Gwennaëlle',
        'H?l?na' => 'Héléna',
        'H?l?ne' => 'Hélène',
        'H?lo?se' => 'Héloïse',
        'Helo?se' => 'Heloïse',
        'Herv?' => 'Hervé',
        'In?s' => 'Inès',
        'Ir?ne' => 'Irène',
        'Jos?phine' => 'Joséphine',
        'L?a' => 'Léa',
        'L?ah' => 'Léah',
        'L?ana' => 'Léana',
        'L?ane' => 'Léane',
        'L?anie' => 'Léanie',
        'L?anne' => 'Léanne',
        'L?na' => 'Léna',
        'L?ona' => 'Léona',
        'L?onie' => 'Léonie',
        'L?onore' => 'Léonore',
        'La?la' => 'Laïla',
        'La?s' => 'Laïs',
        'Ma?lys' => 'Maëlys',
        'Na?ma' => 'Naïma',
        'No?mie' => 'Noémie',
        'Odyss?e' => 'Odyssée',
        'Rapha?l' => 'Raphaël',
        'Rapha?lle' => 'Raphaëlle',
        'Ya?l' => 'Yaël',
        'Ysa?e' => 'Ysaë',
    ];

    $reviewPath = storage_path('app/babies-question-mark-review.csv');
    $directory = dirname($reviewPath);

    if (! File::isDirectory($directory)) {
        File::makeDirectory($directory, 0777, true);
    }

    $reviewHandle = fopen($reviewPath, 'w');
    fputcsv($reviewHandle, ['id', 'lang', 'gender', 'title', 'slug', 'status', 'suggested_title']);

    $fixed = 0;
    $skipped = 0;
    $unresolved = 0;

    Name::query()
        ->where('site_id', $siteId)
        ->where('title', 'like', '%?%')
        ->orderBy('id')
        ->chunkById(200, function ($names) use ($replacements, $reviewHandle, &$fixed, &$skipped, &$unresolved): void {
            foreach ($names as $name) {
                $currentTitle = $name->title;
                $replacement = $replacements[$currentTitle] ?? null;

                if ($replacement === null) {
                    $unresolved++;
                    fputcsv($reviewHandle, [$name->id, $name->lang, $name->gender, $name->title, $name->slug, 'unresolved', '']);
                    continue;
                }

                $duplicateExists = Name::query()
                    ->where('site_id', $name->site_id)
                    ->where('lang', $name->lang)
                    ->where('gender', $name->gender)
                    ->where('title', $replacement)
                    ->whereKeyNot($name->id)
                    ->exists();

                if ($duplicateExists) {
                    $skipped++;
                    fputcsv($reviewHandle, [$name->id, $name->lang, $name->gender, $name->title, $name->slug, 'duplicate-target', $replacement]);
                    continue;
                }

                $name->title = $replacement;
                $name->save();

                $fixed++;
            }
        });

    fclose($reviewHandle);

    $this->info("Correcciones aplicadas: {$fixed}");
    $this->line("Omitidos por duplicado: {$skipped}");
    $this->line("Pendientes de revision: {$unresolved}");
    $this->line("CSV generado: {$reviewPath}");

    return 0;
})->purpose('Corrige nombres con ? de Babies usando reemplazos exactos y exporta el resto para revision');
