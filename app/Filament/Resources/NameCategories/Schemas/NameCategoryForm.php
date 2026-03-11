<?php

namespace App\Filament\Resources\NameCategories\Schemas;

use App\Models\Site;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class NameCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('site_id')
                    ->label('Site')
                    ->options(fn (): array => Site::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label('Name Category')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true, modifyRuleUsing: fn ($rule, Get $get) => $rule->where('site_id', $get('site_id'))),

                TextInput::make('slug')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true, modifyRuleUsing: fn ($rule, Get $get) => $rule->where('site_id', $get('site_id')))
                    ->helperText('Optional. If left blank, it is generated from category name.'),
            ]);
    }
}
