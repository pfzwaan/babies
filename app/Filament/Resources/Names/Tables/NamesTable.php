<?php

namespace App\Filament\Resources\Names\Tables;

use App\Models\GlobalContent;
use App\Models\Name;
use App\Models\NameCategory;
use App\Models\Site;
use App\Services\NameAiContentGenerator;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class NamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('site.name')
                    ->label('Site')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nameCategory.name')
                    ->label('Name Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tags')
                    ->formatStateUsing(fn ($state): string => collect($state ?? [])->filter()->implode(', '))
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label('Likes')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('generate_ai')
                    ->label('Generate AI')
                    ->icon('heroicon-o-sparkles')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        try {
                            $content = app(NameAiContentGenerator::class)->generateForName($record);
                            $record->update(['ai_content' => $content]);

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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('generate_ai_bulk')
                        ->label('Generate AI Content')
                        ->icon('heroicon-o-sparkles')
                        ->form([
                            Select::make('operation')
                                ->label('Operation')
                                ->options([
                                    'update_existing' => 'Update selected existing names',
                                    'create_or_update' => 'Create missing names from list (upsert)',
                                ])
                                ->default(fn () => (string) (GlobalContent::singleton()->name_ai_names_mode ?: 'update_existing'))
                                ->required(),
                            Select::make('name_category_id')
                                ->label('Category for new names')
                                ->options(fn (callable $get) => NameCategory::query()
                                    ->when($get('site_id'), fn ($query, $siteId) => $query->where('site_id', (int) $siteId))
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->all())
                                ->searchable()
                                ->required(fn (callable $get): bool => $get('operation') === 'create_or_update')
                                ->visible(fn (callable $get): bool => $get('operation') === 'create_or_update'),
                            Select::make('site_id')
                                ->label('Site for new names')
                                ->options(fn () => Site::query()->orderBy('name')->pluck('name', 'id')->all())
                                ->searchable()
                                ->required(fn (callable $get): bool => $get('operation') === 'create_or_update')
                                ->visible(fn (callable $get): bool => $get('operation') === 'create_or_update'),
                            Select::make('gender')
                                ->label('Gender for new names')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                ])
                                ->visible(fn (callable $get): bool => $get('operation') === 'create_or_update'),
                            Textarea::make('names_list')
                                ->label('Names list (one per line)')
                                ->rows(10)
                                ->placeholder("Luna\nMax\nBella")
                                ->visible(fn (callable $get): bool => $get('operation') === 'create_or_update'),
                        ])
                        ->requiresConfirmation()
                        ->action(function (Collection $records, array $data): void {
                            $generator = app(NameAiContentGenerator::class);
                            $ok = 0;
                            $failed = 0;
                            $created = 0;
                            $operation = (string) ($data['operation'] ?? 'update_existing');
                            $recordsToProcess = collect();

                            if ($operation === 'create_or_update') {
                                $categoryId = (int) ($data['name_category_id'] ?? 0);
                                $category = NameCategory::query()->find($categoryId);
                                $siteId = (int) ($data['site_id'] ?? 0);
                                $site = Site::query()->find($siteId);

                                if (! $category) {
                                    Notification::make()
                                        ->title('Category is required')
                                        ->body('Selecteer een category om nieuwe names aan te maken.')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                if (! $site) {
                                    Notification::make()
                                        ->title('Site is required')
                                        ->body('Selecteer een site om nieuwe names aan te maken.')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                if ($category && (int) $category->site_id !== (int) $site->id) {
                                    Notification::make()
                                        ->title('Category does not belong to selected site')
                                        ->body('Kies een category die hoort bij het geselecteerde site.')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                $gender = (string) ($data['gender'] ?? '');
                                $gender = in_array($gender, ['male', 'female'], true) ? $gender : null;
                                $titles = collect(preg_split('/\r\n|\r|\n/', (string) ($data['names_list'] ?? '')))
                                    ->map(fn ($title) => trim((string) $title))
                                    ->filter()
                                    ->unique()
                                    ->values();

                                if ($titles->isEmpty()) {
                                    Notification::make()
                                        ->title('Names list is empty')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                foreach ($titles as $title) {
                                    $record = Name::query()->firstOrCreate(
                                        [
                                            'title' => $title,
                                            'name_category_id' => $category->id,
                                            'site_id' => $site->id,
                                        ],
                                        [
                                            'gender' => $gender,
                                        ]
                                    );

                                    if ($record->wasRecentlyCreated) {
                                        $created++;
                                    } elseif ($gender && blank($record->gender)) {
                                        $record->update(['gender' => $gender]);
                                    }

                                    $recordsToProcess->push($record);
                                }
                            } else {
                                $recordsToProcess = $records->values();
                            }

                            if ($recordsToProcess->isEmpty()) {
                                Notification::make()
                                    ->title('No records selected')
                                    ->danger()
                                    ->send();

                                return;
                            }

                            foreach ($recordsToProcess as $record) {
                                try {
                                    $content = $generator->generateForName($record);
                                    $record->update(['ai_content' => $content]);
                                    $ok++;
                                } catch (Throwable) {
                                    $failed++;
                                }
                            }

                            Notification::make()
                                ->title('AI generation finished')
                                ->body("Success: {$ok} | Failed: {$failed} | Created: {$created}")
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
