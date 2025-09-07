<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'language_code',
        'name',
        'description',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    /**
     * Get effective SEO title (fallback to name if seo_title is empty)
     */
    public function getEffectiveSeoTitleAttribute()
    {
        return $this->seo_title ?: $this->name;
    }

    /**
     * Get effective SEO description (fallback to description if seo_description is empty)
     */
    public function getEffectiveSeoDescriptionAttribute()
    {
        return $this->seo_description ?: $this->description;
    }
}
