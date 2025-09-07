<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Blog Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(Category::whereNull('parent_id')->pluck('slug', 'id'))
                            ->searchable()
                            ->placeholder('Select parent category (optional)')
                            ->helperText('Leave empty for root category'),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('technology, lifestyle, travel')
                            ->helperText('URL-friendly identifier'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('parent.slug')
                    ->label('Parent Category')
                    ->sortable()
                    ->placeholder('Root Category'),

                Tables\Columns\BadgeColumn::make('translations_count')
                    ->label('Languages')
                    ->counts('translations')
                    ->color('success'),

                Tables\Columns\BadgeColumn::make('blogs_count')
                    ->label('Posts')
                    ->counts('blogs')
                    ->color('info'),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(Category::whereNull('parent_id')->pluck('slug', 'id'))
                    ->placeholder('All Categories'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TranslationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
