<?php

namespace App\Filament\Resources\Navigations\Pages;

use App\Filament\Resources\Navigations\NavigationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditNavigation extends EditRecord
{
    protected static string $resource = NavigationResource::class;

    protected Width | string | null $maxContentWidth = Width::SevenExtraLarge;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
