<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Language;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class BlogStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Posts', Blog::count())
                ->description('All blog posts')
                ->descriptionIcon('heroicon-s-document-text')
                ->color('primary'),
            
            Card::make('Published Posts', Blog::where('status', 'published')->count())
                ->description('Live posts')
                ->descriptionIcon('heroicon-s-eye')
                ->color('success'),
            
            Card::make('Draft Posts', Blog::where('status', 'draft')->count())
                ->description('Unpublished posts')
                ->descriptionIcon('heroicon-s-pencil')
                ->color('warning'),
            
            Card::make('Featured Posts', Blog::where('is_featured', true)->count())
                ->description('Featured content')
                ->descriptionIcon('heroicon-s-star')
                ->color('info'),
            
            Card::make('Total Views', Blog::sum('view_count'))
                ->description('All time views')
                ->descriptionIcon('heroicon-s-chart-bar')
                ->color('success'),
            
            Card::make('Categories', Category::count())
                ->description('Blog categories')
                ->descriptionIcon('heroicon-s-folder')
                ->color('secondary'),
            
            Card::make('Tags', Tag::count())
                ->description('Blog tags')
                ->descriptionIcon('heroicon-s-tag')
                ->color('secondary'),
            
            Card::make('Languages', Language::where('is_active', true)->count())
                ->description('Active languages')
                ->descriptionIcon('heroicon-s-translate')
                ->color('primary'),
        ];
    }
}
