<?php

namespace App\Filament\Pages;

use App\Models\GlobalContent;
use App\Models\Site;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ContactFormsSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contact Forms';

    protected static UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.contact-forms-settings';

    public ?array $data = [];
    public ?int $siteId = null;

    public function mount(): void
    {
        $this->siteId = Site::defaultSite()?->id;
        $this->fillFormFromSite($this->siteId);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Multisite')
                    ->description('Selecteer voor welk site-record je de contactinstellingen wilt bewerken.')
                    ->schema([
                        Select::make('site_id')
                            ->label('Site')
                            ->options(fn (): array => Site::query()->orderBy('name')->pluck('name', 'id')->all())
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state): void {
                                $this->siteId = blank($state) ? null : (int) $state;
                                $this->fillFormFromSite($this->siteId);
                            }),
                    ]),

                Section::make('Contact Forms')
                    ->schema([
                        TextInput::make('contact_forms_title')
                            ->label('Section title')
                            ->maxLength(255),

                        Textarea::make('contact_forms_intro')
                            ->label('Section intro')
                            ->rows(3),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $siteId = (int) ($state['site_id'] ?? $this->siteId ?? 0);
        $globalContent = GlobalContent::singleton($siteId ?: null);

        unset($state['site_id']);
        $globalContent->fill($state);
        $globalContent->site_id = $siteId ?: null;
        $globalContent->save();

        Notification::make()
            ->title('Contact forms settings updated')
            ->success()
            ->send();
    }

    private function fillFormFromSite(?int $siteId): void
    {
        $globalContent = GlobalContent::singleton($siteId);

        $this->form->fill([
            'site_id' => $siteId,
            ...$globalContent->only([
                'contact_forms_title',
                'contact_forms_intro',
            ]),
        ]);
    }
}
