<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogGroup extends Model
{
    use HasFactory;

    protected $fillable = [];

    /**
     * Relationships
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get blog for specific language
     */
    public function getBlog($languageCode)
    {
        return $this->blogs()->where('language_code', $languageCode)->first();
    }

    /**
     * Get all available languages for this blog group
     */
    public function getAvailableLanguages()
    {
        return $this->blogs()->pluck('language_code')->toArray();
    }

    /**
     * Check if blog exists in specific language
     */
    public function hasLanguage($languageCode)
    {
        return $this->blogs()->where('language_code', $languageCode)->exists();
    }
}
