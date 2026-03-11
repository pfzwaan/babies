<?php

namespace App\Filament\Pages;

use App\Models\GlobalContent;
use BackedEnum;
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

    public function mount(): void
    {
        $globalContent = GlobalContent::singleton();

        $this->form->fill($globalContent->only([
            'contact_forms_title',
            'contact_forms_intro',
        ]));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
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
        $globalContent = GlobalContent::singleton();
        $globalContent->fill($this->form->getState());
        $globalContent->save();

        Notification::make()
            ->title('Contact forms settings updated')
            ->success()
            ->send();
    }
}
