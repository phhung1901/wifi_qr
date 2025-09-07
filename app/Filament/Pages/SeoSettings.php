<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class SeoSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-search-circle';
    protected static ?string $navigationGroup = 'Blog Management';
    protected static ?int $navigationSort = 5;
    protected static string $view = 'filament.pages.seo-settings';

    public $site_name;
    public $site_description;
    public $default_meta_title;
    public $default_meta_description;
    public $google_analytics_id;
    public $google_search_console_id;
    public $facebook_app_id;
    public $twitter_handle;
    public $enable_sitemap;
    public $enable_robots_txt;
    public $meta_tags;

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => config('app.name', 'Blog Site'),
            'site_description' => 'A multilingual blog with SEO optimization',
            'default_meta_title' => 'Blog - Latest Posts and Articles',
            'default_meta_description' => 'Read our latest blog posts and articles on various topics',
            'google_analytics_id' => '',
            'google_search_console_id' => '',
            'facebook_app_id' => '',
            'twitter_handle' => '',
            'enable_sitemap' => true,
            'enable_robots_txt' => true,
            'meta_tags' => [],
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Basic SEO Settings')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('site_name')
                                ->label('Site Name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('default_meta_title')
                                ->label('Default Meta Title')
                                ->required()
                                ->maxLength(255),
                        ]),

                    Textarea::make('site_description')
                        ->label('Site Description')
                        ->required()
                        ->maxLength(500)
                        ->rows(3),

                    Textarea::make('default_meta_description')
                        ->label('Default Meta Description')
                        ->required()
                        ->maxLength(500)
                        ->rows(3),
                ]),

            Section::make('Third-party Integrations')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('google_analytics_id')
                                ->label('Google Analytics ID')
                                ->placeholder('G-XXXXXXXXXX')
                                ->helperText('Google Analytics 4 Measurement ID'),

                            TextInput::make('google_search_console_id')
                                ->label('Google Search Console ID')
                                ->placeholder('google-site-verification=...')
                                ->helperText('Verification meta tag content'),
                        ]),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('facebook_app_id')
                                ->label('Facebook App ID')
                                ->placeholder('123456789012345')
                                ->helperText('For Open Graph integration'),

                            TextInput::make('twitter_handle')
                                ->label('Twitter Handle')
                                ->placeholder('@yourblog')
                                ->helperText('For Twitter Card integration'),
                        ]),
                ]),

            Section::make('Technical SEO')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Toggle::make('enable_sitemap')
                                ->label('Enable XML Sitemap')
                                ->helperText('Generate XML sitemap automatically'),

                            Toggle::make('enable_robots_txt')
                                ->label('Enable Robots.txt')
                                ->helperText('Generate robots.txt file'),
                        ]),
                ]),

            Section::make('Custom Meta Tags')
                ->schema([
                    Repeater::make('meta_tags')
                        ->label('Custom Meta Tags')
                        ->schema([
                            TextInput::make('name')
                                ->label('Meta Name/Property')
                                ->required()
                                ->placeholder('author, keywords, etc.'),

                            TextInput::make('content')
                                ->label('Content')
                                ->required()
                                ->placeholder('Meta tag content'),
                        ])
                        ->columns(2)
                        ->helperText('Add custom meta tags for your site'),
                ]),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // Here you would typically save to database or config files
        // For now, we'll just show a success notification

        Notification::make()
            ->title('SEO Settings Updated')
            ->success()
            ->send();
    }
}
