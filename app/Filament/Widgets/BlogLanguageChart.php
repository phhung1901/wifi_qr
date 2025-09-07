<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Language;
use Filament\Widgets\DoughnutChartWidget;

class BlogLanguageChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Posts by Language';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $languages = Language::withCount('blogs')->get();
        
        return [
            'datasets' => [
                [
                    'label' => 'Posts by Language',
                    'data' => $languages->pluck('blogs_count')->toArray(),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                ],
            ],
            'labels' => $languages->pluck('native_name')->toArray(),
        ];
    }
}
