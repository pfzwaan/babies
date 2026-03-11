<?php

namespace App\Filament\Resources\Names\Pages;

use App\Filament\Resources\Names\NameResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateName extends CreateRecord
{
    protected static string $resource = NameResource::class;

    protected Width|string|null $maxContentWidth = Width::SevenExtraLarge;
}
