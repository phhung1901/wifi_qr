<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogMeta extends Model
{
    use HasFactory;

    protected $table = 'blog_meta';

    protected $fillable = [
        'blog_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * Relationships
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Get meta value by key for a specific blog
     */
    public static function getMetaValue($blogId, $key, $default = null)
    {
        $meta = static::where('blog_id', $blogId)
            ->where('meta_key', $key)
            ->first();

        return $meta ? $meta->meta_value : $default;
    }

    /**
     * Set meta value for a specific blog
     */
    public static function setMetaValue($blogId, $key, $value)
    {
        return static::updateOrCreate(
            ['blog_id' => $blogId, 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }
}
