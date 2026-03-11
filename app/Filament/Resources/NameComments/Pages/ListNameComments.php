<?php

namespace App\Filament\Resources\NameComments\Pages;

use App\Filament\Resources\NameComments\NameCommentResource;
use Filament\Resources\Pages\ListRecords;

class ListNameComments extends ListRecords
{
    protected static string $resource = NameCommentResource::class;
}
