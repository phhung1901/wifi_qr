<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
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

    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
