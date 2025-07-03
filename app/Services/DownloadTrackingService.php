<?php

namespace App\Services;

use App\Models\QrDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DownloadTrackingService
{
    /**
     * Track a QR code download
     */
    public function trackDownload(Request $request, array $options = []): QrDownload
    {
        $sessionId = Session::getId();

        // Get user's country from IP (simplified)
        $country = $this->getCountryFromIP($request->ip());

        return QrDownload::create([
            'session_id' => $sessionId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'download_type' => $options['type'] ?? 'png',
            'wifi_ssid' => $options['ssid'] ?? null,
            'has_logo' => $options['has_logo'] ?? false,
            'has_custom_colors' => $options['has_custom_colors'] ?? false,
            'language' => app()->getLocale(),
            'country' => $country,
            'referrer' => $request->header('referer')
        ]);
    }

    /**
     * Get country from IP address using free API
     */
    private function getCountryFromIP(string $ip): ?string
    {
        // For local/private IPs, return null
        if ($this->isPrivateIP($ip)) {
            return null;
        }

        try {
            // Use free ip-api.com service (100 requests/minute limit)
            $response = file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode");
            $data = json_decode($response, true);

            if ($data && isset($data['countryCode']) && $data['countryCode'] !== 'fail') {
                return $data['countryCode'];
            }
        } catch (\Exception $e) {
            // Log error but don't fail the tracking
            \Log::warning("Failed to get country for IP {$ip}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Check if IP is private/local
     */
    private function isPrivateIP(string $ip): bool
    {
        return !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Get download statistics
     */
    public function getStats(): array
    {
        return [
            'today' => [
                'downloads' => QrDownload::todayCount(),
                'unique_users' => QrDownload::uniqueUsersCount('today'),
                'avg_per_user' => QrDownload::averageDownloadsPerUser('today')
            ],
            'week' => [
                'downloads' => QrDownload::weekCount(),
                'unique_users' => QrDownload::uniqueUsersCount('week'),
                'avg_per_user' => QrDownload::averageDownloadsPerUser('week')
            ],
            'month' => [
                'downloads' => QrDownload::monthCount(),
                'unique_users' => QrDownload::uniqueUsersCount('month'),
                'avg_per_user' => QrDownload::averageDownloadsPerUser('month')
            ],
            'total' => QrDownload::count()
        ];
    }

    /**
     * Get popular download types
     */
    public function getPopularTypes(): array
    {
        return QrDownload::selectRaw('download_type, COUNT(*) as count')
            ->groupBy('download_type')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get language distribution
     */
    public function getLanguageStats(): array
    {
        return QrDownload::selectRaw('language, COUNT(*) as count')
            ->groupBy('language')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get country distribution
     */
    public function getCountryStats(): array
    {
        return QrDownload::selectRaw('country, COUNT(*) as count')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get hourly distribution for today
     */
    public function getHourlyStats(): array
    {
        return QrDownload::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->toArray();
    }

    /**
     * Get daily stats for the last 30 days
     */
    public function getDailyStats(int $days = 30): array
    {
        return QrDownload::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
