<?php

namespace App\Services;

use App\Models\QrDownload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get conversion rate (downloads vs page views)
     * Note: This would require page view tracking to be fully accurate
     */
    public function getConversionRate($period = 'today'): array
    {
        // For now, we'll estimate based on unique sessions vs downloads
        $downloads = 0;
        $uniqueSessions = 0;
        
        switch ($period) {
            case 'week':
                $downloads = QrDownload::weekCount();
                $uniqueSessions = QrDownload::uniqueUsersCount('week');
                break;
            case 'month':
                $downloads = QrDownload::monthCount();
                $uniqueSessions = QrDownload::uniqueUsersCount('month');
                break;
            default:
                $downloads = QrDownload::todayCount();
                $uniqueSessions = QrDownload::uniqueUsersCount('today');
        }
        
        // Estimate page views as 3x unique sessions (rough estimate)
        $estimatedPageViews = $uniqueSessions * 3;
        $conversionRate = $estimatedPageViews > 0 ? ($downloads / $estimatedPageViews) * 100 : 0;
        
        return [
            'downloads' => $downloads,
            'estimated_page_views' => $estimatedPageViews,
            'conversion_rate' => round($conversionRate, 2)
        ];
    }

    /**
     * Get peak usage hours
     */
    public function getPeakHours(): array
    {
        return QrDownload::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'hour' => $item->hour . ':00',
                    'downloads' => $item->count
                ];
            })
            ->toArray();
    }

    /**
     * Get growth rate compared to previous period
     */
    public function getGrowthRate($period = 'week'): array
    {
        $currentPeriodStart = null;
        $currentPeriodEnd = Carbon::now();
        $previousPeriodStart = null;
        $previousPeriodEnd = null;
        
        switch ($period) {
            case 'month':
                $currentPeriodStart = Carbon::now()->startOfMonth();
                $previousPeriodStart = Carbon::now()->subMonth()->startOfMonth();
                $previousPeriodEnd = Carbon::now()->subMonth()->endOfMonth();
                break;
            default: // week
                $currentPeriodStart = Carbon::now()->startOfWeek();
                $previousPeriodStart = Carbon::now()->subWeek()->startOfWeek();
                $previousPeriodEnd = Carbon::now()->subWeek()->endOfWeek();
        }
        
        $currentCount = QrDownload::whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count();
        $previousCount = QrDownload::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        
        $growthRate = $previousCount > 0 ? (($currentCount - $previousCount) / $previousCount) * 100 : 0;
        
        return [
            'current_period' => $currentCount,
            'previous_period' => $previousCount,
            'growth_rate' => round($growthRate, 2),
            'is_positive' => $growthRate >= 0
        ];
    }

    /**
     * Get device type distribution
     */
    public function getDeviceStats(): array
    {
        $stats = QrDownload::selectRaw('
            CASE 
                WHEN user_agent LIKE "%Mobile%" OR user_agent LIKE "%iPhone%" OR user_agent LIKE "%Android%" THEN "Mobile"
                WHEN user_agent LIKE "%iPad%" OR user_agent LIKE "%Tablet%" THEN "Tablet"
                ELSE "Desktop"
            END as device_type,
            COUNT(*) as count
        ')
        ->groupBy('device_type')
        ->orderBy('count', 'desc')
        ->get()
        ->toArray();
        
        return $stats;
    }

    /**
     * Get most popular WiFi names
     */
    public function getPopularWiFiNames(): array
    {
        return QrDownload::selectRaw('wifi_ssid, COUNT(*) as count')
            ->whereNotNull('wifi_ssid')
            ->groupBy('wifi_ssid')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get customization usage stats
     */
    public function getCustomizationStats(): array
    {
        $total = QrDownload::count();
        $withLogo = QrDownload::where('has_logo', true)->count();
        $withCustomColors = QrDownload::where('has_custom_colors', true)->count();
        $withBoth = QrDownload::where('has_logo', true)->where('has_custom_colors', true)->count();
        
        return [
            'total_downloads' => $total,
            'with_logo' => $withLogo,
            'with_custom_colors' => $withCustomColors,
            'with_both' => $withBoth,
            'logo_percentage' => $total > 0 ? round(($withLogo / $total) * 100, 1) : 0,
            'colors_percentage' => $total > 0 ? round(($withCustomColors / $total) * 100, 1) : 0,
            'both_percentage' => $total > 0 ? round(($withBoth / $total) * 100, 1) : 0
        ];
    }

    /**
     * Get referrer stats
     */
    public function getReferrerStats(): array
    {
        return QrDownload::selectRaw('
            CASE 
                WHEN referrer IS NULL THEN "Direct"
                WHEN referrer LIKE "%google%" THEN "Google"
                WHEN referrer LIKE "%facebook%" THEN "Facebook"
                WHEN referrer LIKE "%twitter%" THEN "Twitter"
                WHEN referrer LIKE "%linkedin%" THEN "LinkedIn"
                ELSE "Other"
            END as referrer_type,
            COUNT(*) as count
        ')
        ->groupBy('referrer_type')
        ->orderBy('count', 'desc')
        ->get()
        ->toArray();
    }

    /**
     * Get comprehensive dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'conversion_rates' => [
                'today' => $this->getConversionRate('today'),
                'week' => $this->getConversionRate('week'),
                'month' => $this->getConversionRate('month')
            ],
            'peak_hours' => $this->getPeakHours(),
            'growth_rates' => [
                'week' => $this->getGrowthRate('week'),
                'month' => $this->getGrowthRate('month')
            ],
            'device_stats' => $this->getDeviceStats(),
            'popular_wifi_names' => $this->getPopularWiFiNames(),
            'customization_stats' => $this->getCustomizationStats(),
            'referrer_stats' => $this->getReferrerStats()
        ];
    }
}
