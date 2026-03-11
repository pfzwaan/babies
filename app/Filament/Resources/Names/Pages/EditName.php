<?php

namespace App\Filament\Resources\Names\Pages;

use App\Filament\Resources\Names\NameResource;
use App\Services\NameAiContentGenerator;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Throwable;

class EditName extends EditRecord
{
    protected static string $resource = NameResource::class;

    protected Width|string|null $maxContentWidth = Width::SevenExtraLarge;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_ai')
                ->label('Generate AI')
                ->icon('heroicon-o-sparkles')
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $content = app(NameAiContentGenerator::class)->generateForName($this->record);
                        $this->record->update(['ai_content' => $content]);

                        Notification::make()
                            ->title('AI content generated')
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('AI generation failed')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            DeleteAction::make(),
        ];
    }
}
