<?php

namespace App\Filament\Pages;

use App\Models\GlobalContent;
use App\Models\Navigation;
use BackedEnum;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class GlobalContents extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $navigationLabel = 'Global Contents';

    protected static UnitEnum|string|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 110;

    protected string $view = 'filament.pages.global-contents';

    public ?array $data = [];

    public function mount(): void
    {
        $globalContent = GlobalContent::singleton();

        $this->form->fill($globalContent->only([
            'header_cta_label',
            'header_cta_url',
            'footer_title_1',
            'footer_content_1',
            'footer_title_2',
            'footer_navigation_2_id',
            'footer_content_2',
            'footer_title_3',
            'footer_navigation_3_id',
            'footer_content_3',
            'footer_title_4',
            'footer_content_4',
            'footer_social_label',
            'footer_social_facebook_url',
            'footer_social_instagram_url',
            'footer_social_tiktok_url',
            'footer_social_youtube_url',
            'name_ai_openai_api_key',
            'name_ai_model',
            'name_ai_prompt',
            'name_ai_keywords',
            'name_ai_temperature',
            'name_ai_max_tokens',
            'name_ai_targets',
            'name_ai_names_mode',
        ]));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Header')
                    ->schema([
                        TextInput::make('header_cta_label')
                            ->label('CTA Label')
                            ->maxLength(255),
                        TextInput::make('header_cta_url')
                            ->label('CTA URL')
                            ->url()
                            ->maxLength(2048),
                    ])
                    ->columns(2),

                Section::make('Footer')
                    ->schema([
                        TextInput::make('footer_title_1')
                            ->label('Footer Title 1')
                            ->maxLength(255),
                        RichEditor::make('footer_content_1')
                            ->label('Footer Content 1')
                            ->columnSpanFull(),
                        TextInput::make('footer_title_2')
                            ->label('Footer Title 2')
                            ->maxLength(255),
                        Select::make('footer_navigation_2_id')
                            ->label('Footer Navigation 2')
                            ->options(fn (): array => Navigation::query()
                                ->orderByDesc('status')
                                ->orderBy('name')
                                ->get()
                                ->mapWithKeys(fn (Navigation $navigation): array => [
                                    $navigation->id => "{$navigation->name} ({$navigation->location}) [{$navigation->status}]",
                                ])
                                ->all())
                            ->searchable()
                            ->preload()
                            ->helperText('Select an existing navigation. If empty, Footer Content 2 is used.')
                            ->columnSpanFull(),
                        RichEditor::make('footer_content_2')
                            ->label('Footer Content 2 (fallback)')
                            ->helperText('Used only when no footer navigation is selected.')
                            ->columnSpanFull(),
                        TextInput::make('footer_title_3')
                            ->label('Footer Title 3')
                            ->maxLength(255),
                        Select::make('footer_navigation_3_id')
                            ->label('Footer Navigation 3')
                            ->options(fn (): array => Navigation::query()
                                ->orderByDesc('status')
                                ->orderBy('name')
                                ->get()
                                ->mapWithKeys(fn (Navigation $navigation): array => [
                                    $navigation->id => "{$navigation->name} ({$navigation->location}) [{$navigation->status}]",
                                ])
                                ->all())
                            ->searchable()
                            ->preload()
                            ->helperText('Select an existing navigation. If empty, Footer Content 3 is used.')
                            ->columnSpanFull(),
                        RichEditor::make('footer_content_3')
                            ->label('Footer Content 3 (fallback)')
                            ->helperText('Used only when no footer navigation is selected.')
                            ->columnSpanFull(),
                        TextInput::make('footer_title_4')
                            ->label('Footer Title 4')
                            ->maxLength(255),
                        RichEditor::make('footer_content_4')
                            ->label('Footer Content 4')
                            ->columnSpanFull(),

                        TextInput::make('footer_social_label')
                            ->label('Social label')
                            ->default('Volg ons via:')
                            ->maxLength(255),
                        TextInput::make('footer_social_facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(2048),
                        TextInput::make('footer_social_instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(2048),
                        TextInput::make('footer_social_tiktok_url')
                            ->label('TikTok URL')
                            ->url()
                            ->maxLength(2048),
                        TextInput::make('footer_social_youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(2048),
                    ]),

                Section::make('Name AI Generator')
                    ->description('Instellingen voor AI-content die wordt gegenereerd voor de Name single pagina.')
                    ->schema([
                        TextInput::make('name_ai_openai_api_key')
                            ->label('OpenAI API Key')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(500),
                        TextInput::make('name_ai_model')
                            ->label('Model')
                            ->default('gpt-4o-mini')
                            ->maxLength(100),
                        CheckboxList::make('name_ai_targets')
                            ->label('Generate for')
                            ->options([
                                'names' => 'Names',
                                'name_categories' => 'Name Categories',
                                'blogs' => 'Blogs',
                            ])
                            ->default(['names'])
                            ->columns(1),
                        Select::make('name_ai_names_mode')
                            ->label('Names mode')
                            ->options([
                                'update_existing' => 'Update existing names',
                                'create_or_update' => 'Create missing names (upsert)',
                            ])
                            ->default('update_existing')
                            ->helperText('Gebruik "create_or_update" om ontbrekende namen aan te maken tijdens bulk generatie.')
                            ->visible(fn (callable $get): bool => in_array('names', (array) $get('name_ai_targets'), true)),
                        Textarea::make('name_ai_keywords')
                            ->label('Keywords (optioneel)')
                            ->rows(3)
                            ->helperText('Bijv: vriendelijk, origineel, stoer, kort, Nederlands'),
                        TextInput::make('name_ai_temperature')
                            ->label('Temperature')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(2)
                            ->default(0.7),
                        TextInput::make('name_ai_max_tokens')
                            ->label('Max tokens')
                            ->numeric()
                            ->minValue(300)
                            ->maxValue(4000)
                            ->default(1400),
                        Textarea::make('name_ai_prompt')
                            ->label('Prompt template')
                            ->rows(14)
                            ->columnSpanFull()
                            ->helperText('Je kunt placeholders gebruiken: {{name}}, {{category}}, {{gender}}, {{keywords}}'),
                    ])
                    ->columns(2),
            ]);
    }

    public function save(): void
    {
        $globalContent = GlobalContent::singleton();

        $state = $this->form->getState();

        $globalContent->fill($state);
        $globalContent->save();

        Notification::make()
            ->title('Global contents updated')
            ->success()
            ->send();
    }
}
