<?php

namespace App\Filament\Resources\NameComments\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NameCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name.title')
                    ->label('Name')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('author_name')
                    ->label('Author')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('author_email')
                    ->label('Email')
                    ->disabled()
                    ->dehydrated(false),
                Textarea::make('message')
                    ->rows(6)
                    ->disabled()
                    ->dehydrated(false),
                Toggle::make('is_approved')
                    ->label('Approved')
                    ->live(),
                Placeholder::make('approved_at_info')
                    ->label('Approved at')
                    ->content(fn ($record) => $record?->approved_at?->format('d-m-Y H:i') ?: '-'),
            ]);
    }
}
