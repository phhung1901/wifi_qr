<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function translations()
    {
        return $this->hasMany(TagTranslation::class);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags');
    }

    /**
     * Get translation for specific language
     */
    public function getTranslation($languageCode)
    {
        return $this->translations()->where('language_code', $languageCode)->first();
    }

    /**
     * Get name in specific language
     */
    public function getName($languageCode)
    {
        $translation = $this->getTranslation($languageCode);
        return $translation ? $translation->name : $this->slug;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
