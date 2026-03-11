<?php

namespace App\Filament\Resources\NameCategories\Pages;

use App\Filament\Resources\NameCategories\NameCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditNameCategory extends EditRecord
{
    protected static string $resource = NameCategoryResource::class;

    protected Width|string|null $maxContentWidth = Width::FourExtraLarge;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
