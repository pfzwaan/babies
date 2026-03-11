<?php

namespace App\Filament\Resources\NameCategories\Pages;

use App\Filament\Resources\NameCategories\NameCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateNameCategory extends CreateRecord
{
    protected static string $resource = NameCategoryResource::class;

    protected Width|string|null $maxContentWidth = Width::FourExtraLarge;
}
