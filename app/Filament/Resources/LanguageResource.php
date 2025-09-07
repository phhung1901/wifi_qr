<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Filament\Resources\LanguageResource\RelationManagers;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-translate';
    protected static ?string $navigationGroup = 'Blog Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Language Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(10)
                            ->placeholder('vi, en, ja, ko, zh')
                            ->helperText('ISO language code (e.g., vi, en, ja)'),

                        Forms\Components\TextInput::make('name')
                            ->label('English Name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Vietnamese, English, Japanese'),

                        Forms\Components\TextInput::make('native_name')
                            ->label('Native Name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Tiếng Việt, English, 日本語'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_default')
                                    ->label('Default Language')
                                    ->helperText('Only one language can be default'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('code')
                    ->label('Code')
                    ->sortable()
                    ->searchable()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('English Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('native_name')
                    ->label('Native Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BooleanColumn::make('is_default')
                    ->label('Default')
                    ->sortable(),

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
                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('Default Language'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
