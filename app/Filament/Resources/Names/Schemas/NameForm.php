<?php

namespace App\Filament\Resources\Names\Schemas;

use App\Models\NameCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make('Name Content')
                        ->grow(true)
                        ->schema([
                            Section::make('Basics')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Name')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('slug')
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true)
                                        ->helperText('Optional. If left blank, it is generated from name.'),

                                    Select::make('site_id')
                                        ->label('Site')
                                        ->relationship('site', 'name')
                                        ->required()
                                        ->searchable()
                                        ->preload(),

                                    Select::make('gender')
                                        ->label('Gender')
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ])
                                        ->searchable()
                                        ->preload(),

                                    Select::make('name_category_id')
                                        ->label('Name Category')
                                        ->options(fn (callable $get): array => NameCategory::query()
                                            ->when($get('site_id'), fn ($query, $siteId) => $query->where('site_id', (int) $siteId))
                                            ->orderBy('name')
                                            ->pluck('name', 'id')
                                            ->all())
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->live(),

                                    TagsInput::make('tags')
                                        ->label('Tags')
                                        ->placeholder('Druk enter na elke tag'),
                                ]),

                            Section::make('AI Content (Default Single)')
                                ->schema([
                                    TextInput::make('ai_content.popularity_title')
                                        ->label('Popularity title')
                                        ->maxLength(255),

                                    Textarea::make('ai_content.popularity_text_1')
                                        ->label('Popularity text 1')
                                        ->rows(4),

                                    Textarea::make('ai_content.popularity_text_2')
                                        ->label('Popularity text 2')
                                        ->rows(4),

                                    TextInput::make('ai_content.trend_title')
                                        ->label('Trend title')
                                        ->maxLength(255),

                                    Textarea::make('ai_content.trend_text')
                                        ->label('Trend text')
                                        ->rows(4),

                                    TextInput::make('ai_content.origin_title')
                                        ->label('Origin title')
                                        ->maxLength(255),

                                    TagsInput::make('ai_content.origin_paragraphs')
                                        ->label('Origin paragraphs')
                                        ->placeholder('Voeg paragrafen toe en druk enter'),

                                    TextInput::make('ai_content.famous_title')
                                        ->label('Famous title')
                                        ->maxLength(255),

                                    Textarea::make('ai_content.famous_intro')
                                        ->label('Famous intro')
                                        ->rows(4),

                                    TagsInput::make('ai_content.famous_items')
                                        ->label('Famous items')
                                        ->placeholder('Voeg items toe en druk enter'),

                                    TextInput::make('ai_content.films_title')
                                        ->label('Films title')
                                        ->maxLength(255),

                                    Textarea::make('ai_content.films_text')
                                        ->label('Films text')
                                        ->rows(4),

                                    TextInput::make('ai_content.related_title')
                                        ->label('Related title')
                                        ->maxLength(255),

                                    TagsInput::make('ai_content.related_names')
                                        ->label('Related names')
                                        ->placeholder('Voeg namen toe en druk enter'),
                                ])
                                ->collapsible(),

                            Section::make('AI Content (Babies Single)')
                                ->schema([
                                    Textarea::make('ai_content.meaning')
                                        ->label('Meaning')
                                        ->rows(3),

                                    Textarea::make('ai_content.origin_summary')
                                        ->label('Origin summary')
                                        ->rows(3),

                                    Textarea::make('ai_content.origin_text')
                                        ->label('Origin text')
                                        ->rows(5),
                                ])
                                ->collapsible(),
                        ]),

                    Section::make('SEO')
                        ->grow(false)
                        ->extraAttributes(['class' => 'w-full lg:max-w-sm'])
                        ->schema([
                            TextInput::make('seo.meta_title')
                                ->label('Meta title')
                                ->maxLength(255),

                            Textarea::make('seo.meta_description')
                                ->label('Meta description')
                                ->rows(4)
                                ->maxLength(320),

                            TextInput::make('seo.canonical_url')
                                ->label('Canonical URL')
                                ->url()
                                ->maxLength(2048),

                            Toggle::make('seo.noindex')
                                ->label('Noindex')
                                ->helperText('Adds a noindex directive for this name page.'),
                        ]),
                ])
                    ->from('lg')
                    ->columnSpanFull(),
            ]);
    }
}
