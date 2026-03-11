<?php

namespace App\Filament\Resources\Navigations\Pages;

use App\Filament\Resources\Navigations\NavigationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateNavigation extends CreateRecord
{
    protected static string $resource = NavigationResource::class;

    protected Width | string | null $maxContentWidth = Width::SevenExtraLarge;
}
