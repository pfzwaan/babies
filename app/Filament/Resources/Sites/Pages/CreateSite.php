<?php

namespace App\Filament\Resources\Sites\Pages;

use App\Filament\Resources\Sites\SiteResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected Width|string|null $maxContentWidth = Width::FourExtraLarge;
}
