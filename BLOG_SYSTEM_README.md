# Hệ thống Blog Đa ngôn ngữ với SEO

## Tổng quan

Hệ thống blog đa ngôn ngữ được thiết kế để hỗ trợ nội dung bằng nhiều ngôn ngữ với tính năng SEO mạnh mẽ. Hệ thống bao gồm:

- ✅ **Đa ngôn ngữ**: Hỗ trợ 5 ngôn ngữ (Tiếng Việt, English, 日本語, 한국어, 中文)
- ✅ **SEO tối ưu**: Meta tags, canonical URLs, structured data
- ✅ **Quản lý nội dung**: Categories, Tags, Featured posts
- ✅ **API RESTful**: Endpoints đầy đủ cho frontend
- ✅ **Full-text search**: Tìm kiếm nội dung hiệu quả
- ✅ **Responsive**: Tương thích mọi thiết bị

## Cấu trúc Database

### Bảng chính:
- `languages`: Quản lý ngôn ngữ hệ thống
- `blog_groups`: Nhóm bài viết đa ngôn ngữ
- `blogs`: Bài viết chính
- `categories` + `category_translations`: Danh mục đa ngôn ngữ
- `tags` + `tag_translations`: Thẻ tag đa ngôn ngữ
- `blog_tags`: Quan hệ N-N giữa blogs và tags
- `blog_meta`: Metadata mở rộng

## API Endpoints

### 1. Lấy danh sách ngôn ngữ
```
GET /api/blog/languages
```

### 2. Lấy danh sách bài viết
```
GET /api/blog?lang=vi&category_id=1&per_page=10
```

### 3. Lấy bài viết nổi bật
```
GET /api/blog/featured?lang=vi&limit=5
```

### 4. Lấy chi tiết bài viết
```
GET /api/blog/{slug}?lang=vi
```

### 5. Tìm kiếm bài viết
```
GET /api/blog/search?q=keyword&lang=vi&per_page=10
```

### 6. Lấy bài viết theo danh mục
```
GET /api/blog/category/{categoryId}?lang=vi&per_page=10
```

### 7. Lấy bài viết theo tag
```
GET /api/blog/tag/{tagId}?lang=vi&per_page=10
```

### 8. Lấy danh sách danh mục
```
GET /api/blog/categories?lang=vi
```

### 9. Lấy danh sách tags
```
GET /api/blog/tags?lang=vi
```

### 10. Thống kê blog
```
GET /api/blog/statistics?lang=vi
```

## Sử dụng Models

### Tạo blog mới
```php
use App\Services\BlogService;

$blogService = new BlogService();

$result = $blogService->createBlogGroup([
    'languages' => [
        'vi' => [
            'category_id' => 1,
            'title' => 'Tiêu đề bài viết',
            'slug' => 'tieu-de-bai-viet',
            'excerpt' => 'Tóm tắt bài viết',
            'content' => 'Nội dung bài viết...',
            'status' => 'published',
            'is_featured' => true,
            'tag_ids' => [1, 2]
        ],
        'en' => [
            'category_id' => 1,
            'title' => 'Article Title',
            'slug' => 'article-title',
            'excerpt' => 'Article excerpt',
            'content' => 'Article content...',
            'status' => 'published',
            'is_featured' => true,
            'tag_ids' => [1, 2]
        ]
    ]
]);
```

### Lấy bài viết theo ngôn ngữ
```php
use App\Models\Blog;

$blogs = Blog::byLanguage('vi')
    ->published()
    ->featured()
    ->with(['category', 'tags'])
    ->paginate(10);
```

### Tìm kiếm bài viết
```php
$blogService = new BlogService();
$results = $blogService->searchBlogs('keyword', 'vi', 10);
```

## Tính năng SEO

### 1. Meta Tags tự động
- SEO Title (fallback to title)
- SEO Description (fallback to excerpt)
- SEO Keywords
- Canonical URL

### 2. URL Structure
```
/blog/{language}/{category-slug}/{post-slug}
/blog/vi/cong-nghe/tuong-lai-cua-ai
/blog/en/technology/future-of-ai
```

### 3. Structured Data
- Article schema
- Breadcrumb navigation
- Language alternatives

### 4. Sitemap tự động
- XML sitemap cho từng ngôn ngữ
- Image sitemap
- Sitemap index

## Quản lý nội dung

### 1. Trạng thái bài viết
- `draft`: Bản nháp
- `published`: Đã xuất bản
- `scheduled`: Lên lịch xuất bản
- `archived`: Lưu trữ

### 2. Tính năng nâng cao
- Featured posts (bài viết nổi bật)
- View counter (đếm lượt xem)
- Like counter (đếm lượt thích)
- Comment system (hệ thống bình luận)
- Gallery support (hỗ trợ album ảnh)

## Cài đặt và Sử dụng

### 1. Chạy Migration
```bash
php artisan migrate
```

### 2. Chạy Seeder
```bash
php artisan db:seed --class=LanguageSeeder
php artisan db:seed --class=BlogSeeder
```

### 3. Khởi động server
```bash
php artisan serve
```

### 4. Test API
```bash
# Lấy danh sách ngôn ngữ
curl http://127.0.0.1:8000/api/blog/languages

# Lấy bài viết tiếng Việt
curl http://127.0.0.1:8000/api/blog?lang=vi

# Lấy bài viết nổi bật
curl http://127.0.0.1:8000/api/blog/featured?lang=vi
```

## Mở rộng

### 1. Thêm ngôn ngữ mới
```php
Language::create([
    'code' => 'fr',
    'name' => 'French',
    'native_name' => 'Français',
    'is_active' => true,
    'sort_order' => 6
]);
```

### 2. Tùy chỉnh SEO
```php
$blog->update([
    'seo_title' => 'Custom SEO Title',
    'seo_description' => 'Custom SEO Description',
    'seo_keywords' => 'keyword1, keyword2, keyword3',
    'seo_canonical_url' => 'https://example.com/canonical-url'
]);
```

### 3. Thêm metadata tùy chỉnh
```php
BlogMeta::setMetaValue($blogId, 'custom_field', 'custom_value');
$value = BlogMeta::getMetaValue($blogId, 'custom_field', 'default');
```

## Hiệu suất

- **Indexes tối ưu**: Composite indexes cho các truy vấn phổ biến
- **Eager loading**: Tránh N+1 query problem
- **Caching**: Redis/Memcached support
- **Full-text search**: MySQL FULLTEXT indexes
- **Pagination**: Efficient pagination với cursor-based

## Bảo mật

- **Input validation**: Validate tất cả input
- **XSS protection**: HTML purification
- **SQL injection**: Eloquent ORM protection
- **CSRF protection**: Laravel CSRF middleware
- **Rate limiting**: API rate limiting

Hệ thống đã sẵn sàng để sử dụng và có thể mở rộng dễ dàng!
