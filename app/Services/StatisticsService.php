<?php

namespace App\Services;

use App\Models\Statistics;
use Illuminate\Support\Facades\Cache;

class StatisticsService
{
    const CACHE_KEY = 'qr_statistics';
    const LIVE_CACHE_KEY = 'qr_live_statistics';
    const CACHE_DURATION = 60; // 1 minute
    const LIVE_CACHE_DURATION = 30; // 30 seconds for live count

    /**
     * Get current QR generation count
     */
    public function getCurrentCount(): int
    {
        return Statistics::getValue('total_qr_generated');
    }

    /**
     * Increment QR generation count
     */
    public function incrementQrGenerated(): void
    {
        Statistics::incrementValue('total_qr_generated');
        // Cache::forget(self::CACHE_KEY);
        // Cache::forget(self::LIVE_CACHE_KEY);
    }

    /**
     * Get real-time count with simulated activity
     * This adds a consistent increment to show "live" activity
     */
    public function getLiveCount(): int
    {
        $baseCount = $this->getCurrentCount();

        // Use cumulative increments that only go up, never down
        $currentTime = time();

        // Calculate total seconds since a fixed point (to ensure consistency)
        $startTime = 1751545000; // Fixed timestamp to ensure consistency
        $elapsedSeconds = max(0, $currentTime - $startTime);

        // Progressive increments that only increase over time
        $totalIncrement = 0;

        // Different rates of increment
        $totalIncrement += (int)($elapsedSeconds / 8);  // +1 every 8 seconds
        $totalIncrement += (int)($elapsedSeconds / 12); // +1 every 12 seconds
        $totalIncrement += (int)($elapsedSeconds / 5);  // +1 every 5 seconds

        // Add a small boost every minute to make it more interesting
        $totalIncrement += (int)($elapsedSeconds / 60) * 3; // +3 every minute

        return $baseCount + $totalIncrement;
    }

    /**
     * Simulate background activity by incrementing count periodically
     */
    public function simulateActivity(): void
    {
        // Only increment if it's been more than 60 seconds since last update
        $lastUpdate = 0; // Cache::get('last_activity_simulation', 0);
        $now = time();

        if ($now - $lastUpdate > 60) {
            // Simulate 2-4 QR codes generated in the last 60 seconds
            $increment = rand(2, 4);
            Statistics::incrementValue('total_qr_generated', $increment);
            // Cache::put('last_activity_simulation', $now, 3600);
            // Cache::forget(self::CACHE_KEY);
            // Cache::forget(self::LIVE_CACHE_KEY);
        }
    }

    /**
     * Get formatted count for display
     */
    public function getFormattedCount(): string
    {
        $count = $this->getLiveCount();
        return number_format($count);
    }
}
