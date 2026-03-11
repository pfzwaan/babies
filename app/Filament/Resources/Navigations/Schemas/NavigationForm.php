<?php

namespace App\Filament\Resources\Navigations\Schemas;

use App\Models\NameCategory;
use App\Models\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NavigationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make('Navigation Structure')
                        ->grow(true)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                                    if (filled($get('location'))) {
                                        return;
                                    }

                                    $set('location', Str::slug((string) $state, '-'));
                                }),

                            TextInput::make('location')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText('Key used in templates, e.g. header-menu or footer-menu.'),

                            Repeater::make('items')
                                ->label('Menu Items')
                                ->columnSpanFull()
                                ->defaultItems(0)
                                ->collapsible()
                                ->cloneable()
                                ->reorderable()
                                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                ->schema(self::menuItemSchema(true)),
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

    private static function menuItemSchema(bool $allowChildren): array
    {
        $schema = [
            TextInput::make('label')
                ->required(fn (Get $get): bool => $get('type') === 'custom')
                ->maxLength(255),

            Select::make('type')
                ->options([
                    'page' => 'Page',
                    'name_category' => 'Name Category',
                    'custom' => 'Custom URL',
                ])
                ->default('custom')
                ->required()
                ->live()
                ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                    if (filled($get('label'))) {
                        return;
                    }

                    if ($state === 'page' && filled($get('page_id'))) {
                        $page = Page::query()->find((int) $get('page_id'));

                        if ($page) {
                            $set('label', $page->title);
                        }
                    }

                    if ($state === 'name_category' && filled($get('name_category_id'))) {
                        $category = NameCategory::query()->find((int) $get('name_category_id'));

                        if ($category) {
                            $set('label', $category->name);
                        }
                    }
                }),

            Select::make('page_id')
                ->label('Page')
                ->options(fn (): array => Page::query()
                    ->where('status', 'published')
                    ->orderBy('title')
                    ->pluck('title', 'id')
                    ->all())
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, Get $get, Set $set): void {
                    if ($get('type') !== 'page' || filled($get('label')) || blank($state)) {
                        return;
                    }

                    $page = Page::query()->find((int) $state);

                    if ($page) {
                        $set('label', $page->title);
                    }
                })
                ->visible(fn (Get $get): bool => $get('type') === 'page')
                ->required(fn (Get $get): bool => $get('type') === 'page'),

            Select::make('name_category_id')
                ->label('Name Category')
                ->options(fn (): array => NameCategory::query()
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->all())
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, Get $get, Set $set): void {
                    if ($get('type') !== 'name_category' || filled($get('label')) || blank($state)) {
                        return;
                    }

                    $category = NameCategory::query()->find((int) $state);

                    if ($category) {
                        $set('label', $category->name);
                    }
                })
                ->visible(fn (Get $get): bool => $get('type') === 'name_category')
                ->required(fn (Get $get): bool => $get('type') === 'name_category'),

            TextInput::make('url')
                ->label('URL')
                ->placeholder('/about or https://example.com')
                ->visible(fn (Get $get): bool => $get('type') === 'custom')
                ->required(fn (Get $get): bool => $get('type') === 'custom')
                ->maxLength(2048),

            Toggle::make('open_in_new_tab')
                ->label('Open in new tab')
                ->default(false),
        ];

        if ($allowChildren) {
            $schema[] = Repeater::make('children')
                ->label('Subitems')
                ->defaultItems(0)
                ->collapsible()
                ->cloneable()
                ->reorderable()
                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                ->schema(self::menuItemSchema(false));
        }

        return $schema;
    }
}
