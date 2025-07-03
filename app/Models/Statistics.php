<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'last_updated'
    ];

    protected $casts = [
        'last_updated' => 'datetime',
        'value' => 'integer'
    ];

    /**
     * Get statistic by key
     */
    public static function getByKey(string $key): ?self
    {
        return self::where('key', $key)->first();
    }

    /**
     * Increment statistic value
     */
    public static function incrementValue(string $key, int $amount = 1): void
    {
        $stat = self::getByKey($key);
        if ($stat) {
            $stat->value += $amount;
            $stat->last_updated = now();
            $stat->save();
        }
    }

    /**
     * Get current value for a key
     */
    public static function getValue(string $key): int
    {
        $stat = self::getByKey($key);
        return $stat ? $stat->value : 0;
    }
}
