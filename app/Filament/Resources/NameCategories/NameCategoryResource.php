<?php

namespace App\Filament\Resources\NameCategories;

use App\Filament\Resources\NameCategories\Pages\CreateNameCategory;
use App\Filament\Resources\NameCategories\Pages\EditNameCategory;
use App\Filament\Resources\NameCategories\Pages\ListNameCategories;
use App\Filament\Resources\NameCategories\Schemas\NameCategoryForm;
use App\Filament\Resources\NameCategories\Tables\NameCategoriesTable;
use App\Models\NameCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NameCategoryResource extends Resource
{
    protected static ?string $model = NameCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $navigationLabel = 'Name Categories';
    protected static ?string $pluralModelLabel = 'Name Categories';
    protected static ?string $modelLabel = 'Name Category';
    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return NameCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NameCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNameCategories::route('/'),
            'create' => CreateNameCategory::route('/create'),
            'edit' => EditNameCategory::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
