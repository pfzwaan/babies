<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make('Blog Content')
                        ->grow(true)
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('slug')
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText('Optional. If left blank, it is generated from title.'),

                            Textarea::make('excerpt')
                                ->rows(3)
                                ->maxLength(500)
                                ->helperText('Optional short description for listings.'),

                            RichEditor::make('content')
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'strike',
                                    'h2',
                                    'h3',
                                    'bulletList',
                                    'orderedList',
                                    'blockquote',
                                    'link',
                                    'redo',
                                    'undo',
                                ]),
                        ]),

                    Section::make('Publish')
                        ->grow(false)
                        ->extraAttributes(['class' => 'w-full lg:max-w-sm'])
                        ->schema([
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->default('draft')
                                ->required()
                                ->suffixAction(
                                    Action::make('publish')
                                        ->label('Publish')
                                        ->action(fn (Set $set) => $set('status', 'published'))
                                ),

                            Select::make('blog_category_id')
                                ->label('Category')
                                ->relationship('blogCategory', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('Category name')
                                        ->required()
                                        ->maxLength(255),
                                ]),

                            CuratorPicker::make('thumbnail')
                                ->label('Thumbnail'),
                        ]),
                ])
                    ->from('lg')
                    ->columnSpanFull(),
            ]);
    }
}
