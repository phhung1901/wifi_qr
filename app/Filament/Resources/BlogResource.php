<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('blog_group_id')
                                    ->label('Blog Group')
                                    ->options(\App\Models\BlogGroup::all()->pluck('id', 'id'))
                                    ->searchable()
                                    ->helperText('Group for multilingual posts'),

                                Forms\Components\Select::make('language_code')
                                    ->label('Language')
                                    ->options(\App\Models\Language::pluck('native_name', 'code'))
                                    ->required()
                                    ->searchable(),
                            ]),

                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(\App\Models\Category::all()->pluck('slug', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(500)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->maxLength(1000)
                            ->rows(3)
                            ->helperText('Brief summary of the post'),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpan('full'),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Featured Image')
                                    ->image()
                                    ->directory('blog-images'),

                                Forms\Components\TextInput::make('featured_image_alt')
                                    ->label('Featured Image Alt Text')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Repeater::make('gallery')
                            ->label('Gallery')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->directory('blog-gallery'),
                                Forms\Components\TextInput::make('alt')
                                    ->label('Alt Text')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'scheduled' => 'Scheduled',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ]),

                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('Scheduled At')
                            ->helperText('For scheduled posts'),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Post'),

                                Forms\Components\Toggle::make('allow_comments')
                                    ->label('Allow Comments')
                                    ->default(true),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('tags')
                            ->label('Tags')
                            ->multiple()
                            ->relationship('tags', 'slug')
                            ->preload()
                            ->searchable(),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255)
                            ->helperText('Leave empty to use post title'),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Leave empty to use excerpt'),

                        Forms\Components\TextInput::make('seo_keywords')
                            ->label('SEO Keywords')
                            ->maxLength(500)
                            ->helperText('Comma-separated keywords'),

                        Forms\Components\TextInput::make('seo_canonical_url')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(500)
                            ->helperText('Optional canonical URL'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->size(60)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('language.native_name')
                    ->label('Language')
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('category.slug')
                    ->label('Category')
                    ->color('secondary')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                        'danger' => 'archived',
                    ])
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_featured')
                    ->label('Featured')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('view_count')
                    ->label('Views')
                    ->sortable()
                    ->color('info'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('language_code')
                    ->label('Language')
                    ->options(\App\Models\Language::pluck('native_name', 'code')),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(\App\Models\Category::all()->pluck('slug', 'id')),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                        'archived' => 'Archived',
                    ]),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Posts'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
