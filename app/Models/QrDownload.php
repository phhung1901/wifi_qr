<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QrDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'download_type',
        'wifi_ssid',
        'has_logo',
        'has_custom_colors',
        'language',
        'country',
        'referrer'
    ];

    protected $casts = [
        'has_logo' => 'boolean',
        'has_custom_colors' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get downloads for today
     */
    public static function todayCount(): int
    {
        return self::whereDate('created_at', Carbon::today())->count();
    }

    /**
     * Get downloads for this week
     */
    public static function weekCount(): int
    {
        return self::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
    }

    /**
     * Get downloads for this month
     */
    public static function monthCount(): int
    {
        return self::whereMonth('created_at', Carbon::now()->month)
                   ->whereYear('created_at', Carbon::now()->year)
                   ->count();
    }

    /**
     * Get unique users count
     */
    public static function uniqueUsersCount($period = 'today'): int
    {
        $query = self::distinct('session_id');

        switch ($period) {
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            default:
                $query->whereDate('created_at', Carbon::today());
        }

        return $query->count('session_id');
    }

    /**
     * Get average downloads per user
     */
    public static function averageDownloadsPerUser($period = 'today'): float
    {
        $totalDownloads = 0;
        $uniqueUsers = 0;

        switch ($period) {
            case 'week':
                $totalDownloads = self::weekCount();
                $uniqueUsers = self::uniqueUsersCount('week');
                break;
            case 'month':
                $totalDownloads = self::monthCount();
                $uniqueUsers = self::uniqueUsersCount('month');
                break;
            default:
                $totalDownloads = self::todayCount();
                $uniqueUsers = self::uniqueUsersCount('today');
        }

        return $uniqueUsers > 0 ? round($totalDownloads / $uniqueUsers, 2) : 0;
    }
}
