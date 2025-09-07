<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
        'language_code',
        'name',
        'description',
        'seo_title',
        'seo_description',
    ];

    /**
     * Relationships
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
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
