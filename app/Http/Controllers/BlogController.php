<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use App\Services\LanguageDetectionService;
use App\Models\Language;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    protected $blogService;
    protected $languageService;

    public function __construct(BlogService $blogService, LanguageDetectionService $languageService)
    {
        $this->blogService = $blogService;
        $this->languageService = $languageService;
    }

    /**
     * Get blogs list (API)
     */
    public function index(Request $request): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');
        $categoryId = $request->get('category_id');
        $perPage = $request->get('per_page', 10);

        $blogs = $this->blogService->getPublishedBlogs($languageCode, $perPage, $categoryId);

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'language' => $languageCode
        ]);
    }

    /**
     * Show blogs page (Web View)
     */
    public function indexView(Request $request)
    {
        $currentLocale = $this->languageService->getCurrentLocale();
        $categoryId = $request->get('category_id');
        $perPage = 12; // Show 12 blogs per page for better grid layout

        // Get blogs for current language
        $blogs = $this->blogService->getPublishedBlogs($currentLocale, $perPage, $categoryId);

        // Get featured blogs
        $featuredBlogs = $this->blogService->getFeaturedBlogs($currentLocale, 3);

        // Get categories for filter
        $categories = Category::with(['translations' => function ($query) use ($currentLocale) {
            $query->where('language_code', $currentLocale);
        }])->get();

        // Get blog statistics
        $stats = $this->blogService->getBlogStatistics($currentLocale);

        return view('blogs', [
            'title' => __('app.blogs_title'),
            'description' => __('app.blogs_description'),
            'keywords' => __('app.blogs_keywords'),
            'currentLocale' => $currentLocale,
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
            'blogs' => $blogs,
            'featuredBlogs' => $featuredBlogs,
            'categories' => $categories,
            'stats' => $stats,
            'selectedCategory' => $categoryId
        ]);
    }

    /**
     * Get featured blogs
     */
    public function featured(Request $request): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');
        $limit = $request->get('limit', 5);

        $blogs = $this->blogService->getFeaturedBlogs($languageCode, $limit);

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'language' => $languageCode
        ]);
    }

    /**
     * Get single blog by slug (API)
     */
    public function show(Request $request, $slug): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');

        $blog = $this->blogService->getBlogBySlug($slug, $languageCode);

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found'
            ], 404);
        }

        // Increment view count
        $blog->incrementViewCount();

        // Get related blogs
        $relatedBlogs = $this->blogService->getRelatedBlogs($blog);

        // Get other language versions
        $otherLanguageVersions = $blog->getOtherLanguageVersions();

        return response()->json([
            'success' => true,
            'data' => [
                'blog' => $blog,
                'related_blogs' => $relatedBlogs,
                'other_languages' => $otherLanguageVersions->map(function ($blog) {
                    return [
                        'language_code' => $blog->language_code,
                        'language_name' => $blog->language->native_name,
                        'slug' => $blog->slug,
                        'title' => $blog->title
                    ];
                })
            ],
            'language' => $languageCode
        ]);
    }

    /**
     * Show single blog page (Web View)
     */
    public function showView(Request $request, $slug)
    {
        $currentLocale = $this->languageService->getCurrentLocale();

        $blog = $this->blogService->getBlogBySlug($slug, $currentLocale);

        if (!$blog) {
            abort(404, 'Blog not found');
        }

        // Increment view count
        $blog->incrementViewCount();

        // Get related blogs
        $relatedBlogs = $this->blogService->getRelatedBlogs($blog);

        // Get other language versions
        $otherLanguageVersions = $blog->getOtherLanguageVersions();

        return view('blog-detail', [
            'title' => $blog->effective_seo_title,
            'description' => $blog->effective_seo_description,
            'keywords' => $blog->seo_keywords,
            'currentLocale' => $currentLocale,
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
            'otherLanguageVersions' => $otherLanguageVersions
        ]);
    }

    /**
     * Get blogs by category
     */
    public function byCategory(Request $request, $categoryId): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');
        $perPage = $request->get('per_page', 10);

        $blogs = $this->blogService->getBlogsByCategory($categoryId, $languageCode, $perPage);

        // Get category info
        $category = Category::with(['translations' => function ($query) use ($languageCode) {
            $query->where('language_code', $languageCode);
        }])->find($categoryId);

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'category' => $category,
            'language' => $languageCode
        ]);
    }

    /**
     * Get blogs by tag
     */
    public function byTag(Request $request, $tagId): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');
        $perPage = $request->get('per_page', 10);

        $blogs = $this->blogService->getBlogsByTag($tagId, $languageCode, $perPage);

        // Get tag info
        $tag = Tag::with(['translations' => function ($query) use ($languageCode) {
            $query->where('language_code', $languageCode);
        }])->find($tagId);

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'tag' => $tag,
            'language' => $languageCode
        ]);
    }

    /**
     * Search blogs
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        $languageCode = $request->get('lang', 'vi');
        $perPage = $request->get('per_page', 10);

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $blogs = $this->blogService->searchBlogs($query, $languageCode, $perPage);

        return response()->json([
            'success' => true,
            'data' => $blogs,
            'query' => $query,
            'language' => $languageCode
        ]);
    }

    /**
     * Get blog statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $languageCode = $request->get('lang');

        $stats = $this->blogService->getBlogStatistics($languageCode);

        return response()->json([
            'success' => true,
            'data' => $stats,
            'language' => $languageCode
        ]);
    }

    /**
     * Get available languages
     */
    public function languages(): JsonResponse
    {
        $languages = Language::getActive();

        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }

    /**
     * Get categories for a language
     */
    public function categories(Request $request): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');

        $categories = Category::with(['translations' => function ($query) use ($languageCode) {
            $query->where('language_code', $languageCode);
        }])
        ->active()
        ->ordered()
        ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'language' => $languageCode
        ]);
    }

    /**
     * Get tags for a language
     */
    public function tags(Request $request): JsonResponse
    {
        $languageCode = $request->get('lang', 'vi');

        $tags = Tag::with(['translations' => function ($query) use ($languageCode) {
            $query->where('language_code', $languageCode);
        }])
        ->active()
        ->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
            'language' => $languageCode
        ]);
    }
}
