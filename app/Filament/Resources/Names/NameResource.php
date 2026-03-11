<?php

namespace App\Filament\Resources\Names;

use App\Filament\Resources\Names\Pages\CreateName;
use App\Filament\Resources\Names\Pages\EditName;
use App\Filament\Resources\Names\Pages\ListNames;
use App\Filament\Resources\Names\Schemas\NameForm;
use App\Filament\Resources\Names\Tables\NamesTable;
use App\Models\Name;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NameResource extends Resource
{
    protected static ?string $model = Name::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;
    protected static ?string $navigationLabel = 'Names';
    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return NameForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NamesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNames::route('/'),
            'create' => CreateName::route('/create'),
            'edit' => EditName::route('/{record}/edit'),
        ];
    }
}
