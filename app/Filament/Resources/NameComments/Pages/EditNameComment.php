<?php

namespace App\Filament\Resources\NameComments\Pages;

use App\Filament\Resources\NameComments\NameCommentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNameComment extends EditRecord
{
    protected static string $resource = NameCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $isApproved = (bool) ($data['is_approved'] ?? false);
        $wasApproved = (bool) ($this->record->is_approved ?? false);

        if ($isApproved && ! $wasApproved) {
            $data['approved_at'] = now();
        }

        if (! $isApproved) {
            $data['approved_at'] = null;
        }

        return $data;
    }
}
