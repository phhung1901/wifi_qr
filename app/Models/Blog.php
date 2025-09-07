<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_group_id',
        'language_code',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'gallery',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_canonical_url',
        'status',
        'published_at',
        'scheduled_at',
        'view_count',
        'like_count',
        'comment_count',
        'allow_comments',
        'is_featured',
        'sort_order',
        'author_id',
    ];

    protected $casts = [
        'gallery' => 'array',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function blogGroup()
    {
        return $this->belongsTo(BlogGroup::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags');
    }

    public function meta()
    {
        return $this->hasMany(BlogMeta::class);
    }

    /**
     * Get effective SEO title
     */
    public function getEffectiveSeoTitleAttribute()
    {
        return $this->seo_title ?: $this->title;
    }

    /**
     * Get effective SEO description
     */
    public function getEffectiveSeoDescriptionAttribute()
    {
        return $this->seo_description ?: $this->excerpt;
    }

    /**
     * Scopes
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByLanguage(Builder $query, $languageCode)
    {
        return $query->where('language_code', $languageCode);
    }

    public function scopeByCategory(Builder $query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order')->orderBy('published_at', 'desc');
    }

    /**
     * Get other language versions of this blog
     */
    public function getOtherLanguageVersions()
    {
        return $this->blogGroup->blogs()->where('id', '!=', $this->id)->get();
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
