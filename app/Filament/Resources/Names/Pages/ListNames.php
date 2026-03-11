<?php

namespace App\Filament\Resources\Names\Pages;

use App\Filament\Resources\Names\NameResource;
use App\Models\Name;
use App\Services\NameAiContentGenerator;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListNames extends ListRecords
{
    protected static string $resource = NameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_ai_all_existing')
                ->label('Generate AI (All Existing)')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->form([
                    Select::make('limit')
                        ->label('Limit')
                        ->options([
                            '0' => 'No limit (all existing)',
                            '100' => '100',
                            '500' => '500',
                            '1000' => '1000',
                        ])
                        ->default('0')
                        ->required(),
                ])
                ->requiresConfirmation()
                ->modalDescription('Dit genereert AI-content voor alle bestaande names. Dit kan even duren.')
                ->action(function (array $data): void {
                    $generator = app(NameAiContentGenerator::class);
                    $ok = 0;
                    $failed = 0;
                    $limit = (int) ($data['limit'] ?? 0);
                    $processed = 0;

                    $query = Name::query()->orderBy('id');
                    if ($limit > 0) {
                        $query->limit($limit);
                    }

                    $query->chunkById(100, function ($names) use ($generator, &$ok, &$failed, &$processed, $limit): bool {
                            foreach ($names as $name) {
                                if ($limit > 0 && $processed >= $limit) {
                                    return false;
                                }

                                try {
                                    $content = $generator->generateForName($name);
                                    $name->update(['ai_content' => $content]);
                                    $ok++;
                                } catch (Throwable) {
                                    $failed++;
                                }

                                $processed++;
                            }
                            return true;
                        });

                    Notification::make()
                        ->title('AI generation finished')
                        ->body("Processed: {$processed} | Success: {$ok} | Failed: {$failed}")
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
