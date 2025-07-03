<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DownloadTrackingService;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $trackingService;
    protected $analyticsService;

    public function __construct(DownloadTrackingService $trackingService, AnalyticsService $analyticsService)
    {
        $this->trackingService = $trackingService;
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display the admin dashboard
     */
    public function index(Request $request)
    {
        $stats = $this->trackingService->getStats();
        $popularTypes = $this->trackingService->getPopularTypes();
        $languageStats = $this->trackingService->getLanguageStats();
        $countryStats = $this->trackingService->getCountryStats();
        $hourlyStats = $this->trackingService->getHourlyStats();
        $dailyStats = $this->trackingService->getDailyStats(30);

        // Get advanced analytics
        $analyticsData = $this->analyticsService->getDashboardData();

        return view('admin.dashboard', compact(
            'stats',
            'popularTypes',
            'languageStats',
            'countryStats',
            'hourlyStats',
            'dailyStats',
            'analyticsData'
        ));
    }

    /**
     * Get stats for a specific date range
     */
    public function getStatsForRange(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(7));
        $endDate = $request->input('end_date', Carbon::now());

        // Custom date range stats
        $downloads = \App\Models\QrDownload::whereBetween('created_at', [$startDate, $endDate])->count();
        $uniqueUsers = \App\Models\QrDownload::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('session_id')->count('session_id');

        return response()->json([
            'downloads' => $downloads,
            'unique_users' => $uniqueUsers,
            'avg_per_user' => $uniqueUsers > 0 ? round($downloads / $uniqueUsers, 2) : 0,
            'period' => $startDate . ' to ' . $endDate
        ]);
    }

    /**
     * Export data as CSV
     */
    public function exportCsv(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30));
        $endDate = $request->input('end_date', Carbon::now());

        $downloads = \App\Models\QrDownload::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'qr_downloads_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($downloads) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID', 'Date', 'Time', 'Session ID', 'IP Address',
                'Download Type', 'WiFi SSID', 'Has Logo', 'Has Custom Colors',
                'Language', 'Country', 'User Agent', 'Referrer'
            ]);

            // CSV data
            foreach ($downloads as $download) {
                fputcsv($file, [
                    $download->id,
                    $download->created_at->format('Y-m-d'),
                    $download->created_at->format('H:i:s'),
                    $download->session_id,
                    $download->ip_address,
                    $download->download_type,
                    $download->wifi_ssid,
                    $download->has_logo ? 'Yes' : 'No',
                    $download->has_custom_colors ? 'Yes' : 'No',
                    $download->language,
                    $download->country,
                    $download->user_agent,
                    $download->referrer
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
