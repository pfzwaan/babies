<?php

namespace App\Filament\Resources\NameComments;

use App\Filament\Resources\NameComments\Pages\EditNameComment;
use App\Filament\Resources\NameComments\Pages\ListNameComments;
use App\Filament\Resources\NameComments\Schemas\NameCommentForm;
use App\Filament\Resources\NameComments\Tables\NameCommentsTable;
use App\Models\NameComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NameCommentResource extends Resource
{
    protected static ?string $model = NameComment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;
    protected static ?string $navigationLabel = 'Name Comments';
    protected static ?string $modelLabel = 'Name Comment';
    protected static ?string $pluralModelLabel = 'Name Comments';
    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 55;

    public static function form(Schema $schema): Schema
    {
        return NameCommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NameCommentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNameComments::route('/'),
            'edit' => EditNameComment::route('/{record}/edit'),
        ];
    }
}
