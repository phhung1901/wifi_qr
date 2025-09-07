<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the default language
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->first();
    }

    /**
     * Get active languages ordered by sort_order
     */
    public static function getActive()
    {
        return static::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get language by code
     */
    public static function getByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Relationships
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'language_code', 'code');
    }

    public function categoryTranslations()
    {
        return $this->hasMany(CategoryTranslation::class, 'language_code', 'code');
    }

    public function tagTranslations()
    {
        return $this->hasMany(TagTranslation::class, 'language_code', 'code');
    }
}
