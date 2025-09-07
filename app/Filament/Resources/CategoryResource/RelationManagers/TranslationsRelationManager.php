<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('language_code')
                    ->label('Language')
                    ->options(\App\Models\Language::pluck('native_name', 'code'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(1000)
                    ->rows(3),

                Forms\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255)
                            ->helperText('Leave empty to use category name'),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->maxLength(500)
                            ->rows(2)
                            ->helperText('Leave empty to use description'),

                        Forms\Components\TextInput::make('seo_keywords')
                            ->label('SEO Keywords')
                            ->maxLength(500)
                            ->helperText('Comma-separated keywords'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('language.native_name')
                    ->label('Language')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('seo_title')
                    ->label('SEO Title')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('language_code')
                    ->label('Language')
                    ->options(\App\Models\Language::pluck('native_name', 'code')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
