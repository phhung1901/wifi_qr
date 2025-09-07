<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogGroup;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogService
{
    /**
     * Get published blogs for a specific language
     */
    public function getPublishedBlogs($languageCode, $perPage = 10, $categoryId = null)
    {
        $query = Blog::with(['category', 'tags', 'language'])
            ->byLanguage($languageCode)
            ->published()
            ->ordered();

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get featured blogs for a specific language
     */
    public function getFeaturedBlogs($languageCode, $limit = 5)
    {
        return Blog::with(['category', 'tags', 'language'])
            ->byLanguage($languageCode)
            ->published()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Get blog by slug and language
     */
    public function getBlogBySlug($slug, $languageCode)
    {
        return Blog::with(['category', 'tags', 'language', 'blogGroup.blogs'])
            ->byLanguage($languageCode)
            ->where('slug', $slug)
            ->published()
            ->first();
    }

    /**
     * Create a new blog group with blogs in multiple languages
     */
    public function createBlogGroup($data)
    {
        return DB::transaction(function () use ($data) {
            // Create blog group
            $blogGroup = BlogGroup::create();

            $blogs = [];
            foreach ($data['languages'] as $languageCode => $blogData) {
                $blog = $this->createBlog(array_merge($blogData, [
                    'blog_group_id' => $blogGroup->id,
                    'language_code' => $languageCode
                ]));
                $blogs[$languageCode] = $blog;
            }

            return [
                'blog_group' => $blogGroup,
                'blogs' => $blogs
            ];
        });
    }

    /**
     * Create a single blog
     */
    public function createBlog($data)
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $data['language_code']);
        }

        // Set default values
        $data = array_merge([
            'status' => 'draft',
            'allow_comments' => true,
            'is_featured' => false,
            'view_count' => 0,
            'like_count' => 0,
            'comment_count' => 0,
        ], $data);

        $blog = Blog::create($data);

        // Attach tags if provided
        if (!empty($data['tag_ids'])) {
            $blog->tags()->attach($data['tag_ids']);
        }

        return $blog;
    }

    /**
     * Update blog
     */
    public function updateBlog($blog, $data)
    {
        return DB::transaction(function () use ($blog, $data) {
            // Update slug if title changed
            if (isset($data['title']) && $data['title'] !== $blog->title) {
                if (empty($data['slug'])) {
                    $data['slug'] = $this->generateUniqueSlug($data['title'], $blog->language_code, $blog->id);
                }
            }

            $blog->update($data);

            // Update tags if provided
            if (isset($data['tag_ids'])) {
                $blog->tags()->sync($data['tag_ids']);
            }

            return $blog;
        });
    }

    /**
     * Publish blog
     */
    public function publishBlog($blog)
    {
        $blog->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return $blog;
    }

    /**
     * Schedule blog for publishing
     */
    public function scheduleBlog($blog, $scheduledAt)
    {
        $blog->update([
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt
        ]);

        return $blog;
    }

    /**
     * Get blogs by category
     */
    public function getBlogsByCategory($categoryId, $languageCode, $perPage = 10)
    {
        return Blog::with(['category', 'tags', 'language'])
            ->byLanguage($languageCode)
            ->byCategory($categoryId)
            ->published()
            ->ordered()
            ->paginate($perPage);
    }

    /**
     * Get blogs by tag
     */
    public function getBlogsByTag($tagId, $languageCode, $perPage = 10)
    {
        return Blog::with(['category', 'tags', 'language'])
            ->byLanguage($languageCode)
            ->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            })
            ->published()
            ->ordered()
            ->paginate($perPage);
    }

    /**
     * Search blogs
     */
    public function searchBlogs($query, $languageCode, $perPage = 10)
    {
        return Blog::with(['category', 'tags', 'language'])
            ->byLanguage($languageCode)
            ->published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->ordered()
            ->paginate($perPage);
    }

    /**
     * Get related blogs
     */
    public function getRelatedBlogs($blog, $limit = 5)
    {
        return Blog::with(['category', 'tags', 'language'])
            ->byLanguage($blog->language_code)
            ->published()
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                $query->where('category_id', $blog->category_id)
                      ->orWhereHas('tags', function ($q) use ($blog) {
                          $q->whereIn('tags.id', $blog->tags->pluck('id'));
                      });
            })
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($title, $languageCode, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $languageCode, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists($slug, $languageCode, $excludeId = null)
    {
        $query = Blog::where('slug', $slug)->where('language_code', $languageCode);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get blog statistics
     */
    public function getBlogStatistics($languageCode = null)
    {
        $query = Blog::query();

        if ($languageCode) {
            $query->byLanguage($languageCode);
        }

        return [
            'total' => $query->count(),
            'published' => $query->where('status', 'published')->count(),
            'draft' => $query->where('status', 'draft')->count(),
            'scheduled' => $query->where('status', 'scheduled')->count(),
            'featured' => $query->where('is_featured', true)->count(),
            'total_views' => $query->sum('view_count'),
            'total_likes' => $query->sum('like_count'),
        ];
    }
}
