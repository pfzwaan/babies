<?php

namespace App\Filament\Resources\Pages\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make('Page Content')
                        ->grow(true)
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),

                            Select::make('site_id')
                                ->label('Site')
                                ->relationship('site', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            TextInput::make('slug')
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText('Optional. If left blank, it is generated from title.'),

                            Builder::make('content')
                                ->blocks([
                                    Builder\Block::make('heading')
                                        ->schema([
                                            TextInput::make('text')
                                                ->label('Heading')
                                                ->required()
                                                ->maxLength(255),
                                        ]),
                                    Builder\Block::make('paragraph')
                                        ->schema([
                                            Textarea::make('text')
                                                ->label('Paragraph')
                                                ->required()
                                                ->rows(5),
                                        ]),
                                    Builder\Block::make('image')
                                        ->schema([
                                            CuratorPicker::make('image')
                                                ->label('Image')
                                                ->required(),
                                            TextInput::make('alt')
                                                ->label('Alt text')
                                                ->maxLength(255),
                                        ]),
                                    Builder\Block::make('hero_section')
                                        ->label('Hero Section')
                                        ->schema([
                                            CuratorPicker::make('background_image')
                                                ->label('Background image')
                                                ->required(),
                                            CuratorPicker::make('shape_image')
                                                ->label('Shape image (optional)'),
                                            TextInput::make('title_prefix')
                                                ->label('Title prefix')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Vind de perfecte'),
                                            TextInput::make('title_highlight')
                                                ->label('Title highlight')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('naam'),
                                            TextInput::make('title_suffix')
                                                ->label('Title suffix')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('voor je baby'),
                                            Textarea::make('subtitle')
                                                ->label('Subtitle')
                                                ->required()
                                                ->rows(3)
                                                ->default('Ontdek populaire, moderne en unieke babynamen om inspiratie op te doen.'),
                                        ]),
                                    Builder\Block::make('animal_blocks')
                                        ->label('Animal Blocks')
                                        ->schema([
                                            Repeater::make('cards')
                                                ->label('Cards')
                                                ->schema([
                                                    TextInput::make('title')
                                                        ->required()
                                                        ->maxLength(255),
                                                    Textarea::make('description')
                                                        ->required()
                                                        ->rows(2),
                                                    TextInput::make('button_label')
                                                        ->required()
                                                        ->maxLength(255),
                                                    TextInput::make('url')
                                                        ->label('Button URL')
                                                        ->maxLength(2048),
                                                    CuratorPicker::make('icon')
                                                        ->label('Icon'),
                                                ])
                                                ->minItems(9)
                                                ->maxItems(9)
                                                ->default([
                                                    ['title' => 'Jongensnamen', 'description' => 'Populaire en unieke jongensnamen.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Meisjesnamen', 'description' => 'De mooiste meisjesnamen op een rij.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Unisex namen', 'description' => 'Namen die voor iedereen passen.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Alle namen', 'description' => 'Ontdek alle categorieen en lijsten.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Nederlandse namen', 'description' => 'Traditionele en moderne Nederlandse namen.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Internationale namen', 'description' => 'Namen uit verschillende culturen.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Korte namen', 'description' => 'Korte, krachtige en tijdloze namen.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Unieke namen', 'description' => 'Originele namen met karakter.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                    ['title' => 'Klassieke namen', 'description' => 'Klassieke namen die altijd mooi blijven.', 'button_label' => 'Alles bekijken', 'url' => '#'],
                                                ])
                                                ->columnSpanFull(),
                                        ]),
                                    Builder\Block::make('blogs_section')
                                        ->label('Blogs Section')
                                        ->schema([
                                            TextInput::make('heading_highlight')
                                                ->label('Heading highlight')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Meer dan een naam:'),
                                            TextInput::make('heading_text')
                                                ->label('Heading text')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Blog en tips voor het kiezen van de ideale naam'),
                                            CuratorPicker::make('featured_image')
                                                ->label('Featured image')
                                                ->required(),
                                            TextInput::make('featured_title')
                                                ->label('Featured title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Veelgemaakte fouten bij het kiezen van een babynaam.'),
                                            Textarea::make('featured_excerpt')
                                                ->label('Featured excerpt')
                                                ->required()
                                                ->rows(4)
                                                ->default('Een veelgemaakte fout is kiezen op trend zonder te letten op betekenis, uitspraak en combinatie met de achternaam. Door vooraf stijl, oorsprong en klank te bepalen maak je een keuze die op lange termijn goed voelt.'),
                                            TextInput::make('featured_button_label')
                                                ->label('Featured button label')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Lees meer'),
                                            TextInput::make('featured_url')
                                                ->label('Featured URL')
                                                ->maxLength(2048)
                                                ->default('#'),
                                            TextInput::make('featured_tags')
                                                ->label('Featured tags')
                                                ->maxLength(255)
                                                ->default('#babynamen #jongensnamen #meisjesnamen'),
                                            Repeater::make('cards')
                                                ->label('Blog cards')
                                                ->schema([
                                                    CuratorPicker::make('image')
                                                        ->label('Image')
                                                        ->required(),
                                                    TextInput::make('title')
                                                        ->required()
                                                        ->maxLength(255),
                                                    Textarea::make('excerpt')
                                                        ->required()
                                                        ->rows(3),
                                                    TextInput::make('button_label')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->default('Lees meer'),
                                                    TextInput::make('url')
                                                        ->label('URL')
                                                        ->maxLength(2048)
                                                        ->default('#'),
                                                ])
                                                ->minItems(3)
                                                ->maxItems(3)
                                                ->default([
                                                    ['title' => 'Hoe kies je de perfecte babynaam?', 'excerpt' => 'Van betekenis tot klank: zo maak je een keuze die bij jullie past.', 'button_label' => 'Lees meer', 'url' => '#'],
                                                    ['title' => 'Korte of lange babynamen: wat past beter?', 'excerpt' => 'De voor- en nadelen van korte, lange en samengestelde namen.', 'button_label' => 'Lees meer', 'url' => '#'],
                                                    ['title' => 'Inspiratie voor originele jongens- en meisjesnamen', 'excerpt' => 'Ontdek creatieve bronnen en slimme filters om sneller te kiezen.', 'button_label' => 'Lees meer', 'url' => '#'],
                                                ])
                                                ->columnSpanFull(),
                                            TextInput::make('cta_label')
                                                ->label('CTA label')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Bekijk alle blogposts'),
                                            TextInput::make('cta_url')
                                                ->label('CTA URL')
                                                ->maxLength(2048)
                                                ->default('#'),
                                        ]),
                                    Builder\Block::make('top_10_section')
                                        ->label('Top 10 Section')
                                        ->schema([
                                            TextInput::make('left_title')
                                                ->label('Left column title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Top 10 jongensnamen'),
                                            Repeater::make('left_items')
                                                ->label('Left items')
                                                ->schema([
                                                    TextInput::make('name')
                                                        ->label('Name')
                                                        ->required()
                                                        ->maxLength(255),
                                                ])
                                                ->minItems(10)
                                                ->maxItems(10)
                                                ->default([
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
                                                ]),
                                            TextInput::make('right_title')
                                                ->label('Right column title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Top 10 meisjesnamen'),
                                            Repeater::make('right_items')
                                                ->label('Right items')
                                                ->schema([
                                                    TextInput::make('name')
                                                        ->label('Name')
                                                        ->required()
                                                        ->maxLength(255),
                                                ])
                                                ->minItems(10)
                                                ->maxItems(10)
                                                ->default([
                                                    ['name' => 'Emma'],
                                                    ['name' => 'Olivia'],
                                                    ['name' => 'Mila'],
                                                    ['name' => 'Nora'],
                                                    ['name' => 'Sophie'],
                                                    ['name' => 'Julia'],
                                                    ['name' => 'Lotte'],
                                                    ['name' => 'Sara'],
                                                    ['name' => 'Yara'],
                                                    ['name' => 'Luna'],
                                                ]),
                                        ]),
                                    Builder\Block::make('new_names_section')
                                        ->label('Nieuwe Namen Section')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Nieuwe namen toegevoegd in 2026'),
                                            Repeater::make('items')
                                                ->label('Items')
                                                ->schema([
                                                    TextInput::make('name')
                                                        ->label('Name')
                                                        ->required()
                                                        ->maxLength(255),
                                                    TextInput::make('category')
                                                        ->label('Category')
                                                        ->required()
                                                        ->maxLength(255),
                                                ])
                                                ->minItems(8)
                                                ->maxItems(8)
                                                ->default([
                                                    ['name' => 'Noa', 'category' => 'Jongensnamen'],
                                                    ['name' => 'Liam', 'category' => 'Jongensnamen'],
                                                    ['name' => 'Mila', 'category' => 'Meisjesnamen'],
                                                    ['name' => 'Nora', 'category' => 'Meisjesnamen'],
                                                    ['name' => 'Alex', 'category' => 'Unisex'],
                                                    ['name' => 'Robin', 'category' => 'Unisex'],
                                                    ['name' => 'Luca', 'category' => 'Jongensnamen'],
                                                    ['name' => 'Luna', 'category' => 'Meisjesnamen'],
                                                ]),
                                        ]),
                                    Builder\Block::make('content_block_section')
                                        ->label('Content Block Section')
                                        ->schema([
                                            TextInput::make('intro_title')
                                                ->label('Intro title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Meer over mooie en originele babynamen'),
                                            Textarea::make('intro_text')
                                                ->label('Intro text')
                                                ->required()
                                                ->rows(4)
                                                ->default('Op Babynamengids.nl vind je een uitgebreide verzameling mooie en originele babynamen voor jongens en meisjes.'),
                                            TextInput::make('section_heading')
                                                ->label('Section heading')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Geschiedenis van babynamen'),
                                            Textarea::make('section_text')
                                                ->label('Section text')
                                                ->required()
                                                ->rows(4)
                                                ->default('Babynamen hebben een rijke geschiedenis die vaak teruggaat tot oude culturen, religies en tradities.'),
                                            TextInput::make('subheading_1')
                                                ->label('Sub heading 1')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Nederlandse en buitenlandse namen'),
                                            Textarea::make('subtext_1')
                                                ->label('Sub text 1')
                                                ->required()
                                                ->rows(3)
                                                ->default('Bij Babynamengids.nl vind je een uitgebreide selectie namen uit Nederland en de rest van de wereld.'),
                                            TextInput::make('subheading_2')
                                                ->label('Sub heading 2')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Babynamen per cultuur en afkomst'),
                                            Textarea::make('subtext_2')
                                                ->label('Sub text 2')
                                                ->required()
                                                ->rows(3)
                                                ->default('Ontdek namen uit verschillende culturen, zoals Europese, Aziatische, Afrikaanse en Latijnse tradities.'),
                                            TextInput::make('subheading_3')
                                                ->label('Sub heading 3')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Originele babynaam kiezen: tips en tricks'),
                                            Textarea::make('subtext_3')
                                                ->label('Sub text 3')
                                                ->required()
                                                ->rows(3)
                                                ->default('Bepaal je stijl, onderzoek de betekenis en test de klank met de achternaam.'),
                                        ]),
                                    Builder\Block::make('alphabet_section')
                                        ->label('Alphabet Section')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->required()
                                                ->maxLength(255)
                                                ->default('Namen op alfabet'),
                                            Repeater::make('letters')
                                                ->label('Letters')
                                                ->schema([
                                                    TextInput::make('label')
                                                        ->label('Letter')
                                                        ->required()
                                                        ->maxLength(2),
                                                    TextInput::make('url')
                                                        ->label('URL')
                                                        ->maxLength(2048)
                                                        ->default('#'),
                                                ])
                                                ->minItems(26)
                                                ->maxItems(26)
                                                ->default([
                                                    ['label' => 'A', 'url' => '#'], ['label' => 'B', 'url' => '#'], ['label' => 'C', 'url' => '#'], ['label' => 'D', 'url' => '#'], ['label' => 'E', 'url' => '#'], ['label' => 'F', 'url' => '#'], ['label' => 'G', 'url' => '#'], ['label' => 'H', 'url' => '#'], ['label' => 'I', 'url' => '#'], ['label' => 'J', 'url' => '#'], ['label' => 'K', 'url' => '#'], ['label' => 'L', 'url' => '#'], ['label' => 'M', 'url' => '#'], ['label' => 'N', 'url' => '#'], ['label' => 'O', 'url' => '#'], ['label' => 'P', 'url' => '#'], ['label' => 'Q', 'url' => '#'], ['label' => 'R', 'url' => '#'], ['label' => 'S', 'url' => '#'], ['label' => 'T', 'url' => '#'], ['label' => 'U', 'url' => '#'], ['label' => 'V', 'url' => '#'], ['label' => 'W', 'url' => '#'], ['label' => 'X', 'url' => '#'], ['label' => 'Y', 'url' => '#'], ['label' => 'Z', 'url' => '#'],
                                                ]),
                                        ]),
                                    Builder\Block::make('contact')
                                        ->label('Contact')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title override')
                                                ->maxLength(255)
                                                ->helperText('Optional. If empty, value from Contact Forms settings is used.'),
                                            Textarea::make('intro')
                                                ->label('Intro override')
                                                ->rows(3)
                                                ->helperText('Optional. If empty, value from Contact Forms settings is used.'),
                                            Fieldset::make('Form settings')
                                                ->schema([
                                                    TextInput::make('send_to_email')
                                                        ->label('Send form to email')
                                                        ->email()
                                                        ->maxLength(255)
                                                        ->helperText('Recipient email for contact form submissions.'),
                                                ]),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ]),

                    Section::make('Publish')
                        ->grow(false)
                        ->extraAttributes(['class' => 'w-full lg:max-w-sm'])
                        ->schema([
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->default('draft')
                                ->required()
                                ->suffixAction(
                                    Action::make('publish')
                                        ->label('Publish')
                                        ->action(fn (Set $set) => $set('status', 'published'))
                                ),
                        ]),
                ])
                    ->from('lg')
                    ->columnSpanFull(),
            ]);
    }
}
