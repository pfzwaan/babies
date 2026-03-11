<?php

namespace App\Filament\Resources\Blogs\Pages;

use App\Filament\Resources\Blogs\BlogResource;
use App\Models\Blog;
use App\Services\BlogAiContentGenerator;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

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
                ->modalDescription('Dit genereert AI-content voor alle bestaande blogs. Dit kan even duren.')
                ->action(function (array $data): void {
                    $generator = app(BlogAiContentGenerator::class);
                    $ok = 0;
                    $failed = 0;
                    $processed = 0;
                    $limit = (int) ($data['limit'] ?? 0);

                    $query = Blog::query()->orderBy('id');
                    if ($limit > 0) {
                        $query->limit($limit);
                    }

                    $query->chunkById(100, function ($blogs) use ($generator, &$ok, &$failed, &$processed, $limit): bool {
                        foreach ($blogs as $blog) {
                            if ($limit > 0 && $processed >= $limit) {
                                return false;
                            }

                            try {
                                $ai = $generator->generateForBlog($blog);
                                $blog->update([
                                    'excerpt' => $ai['excerpt'],
                                    'content' => $ai['content'],
                                ]);
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
