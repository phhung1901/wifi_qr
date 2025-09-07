<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Language;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Tag;
use App\Models\TagTranslation;
use App\Models\BlogGroup;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo categories mẫu
        $this->createCategories();
        
        // Tạo tags mẫu
        $this->createTags();
        
        // Tạo blog posts mẫu
        $this->createBlogs();
    }

    private function createCategories()
    {
        $categories = [
            [
                'slug' => 'technology',
                'translations' => [
                    'vi' => ['name' => 'Công nghệ', 'description' => 'Tin tức và bài viết về công nghệ'],
                    'en' => ['name' => 'Technology', 'description' => 'Technology news and articles'],
                    'ja' => ['name' => 'テクノロジー', 'description' => 'テクノロジーのニュースと記事'],
                    'ko' => ['name' => '기술', 'description' => '기술 뉴스 및 기사'],
                    'zh' => ['name' => '技术', 'description' => '技术新闻和文章'],
                ]
            ],
            [
                'slug' => 'lifestyle',
                'translations' => [
                    'vi' => ['name' => 'Lối sống', 'description' => 'Bài viết về lối sống và cuộc sống'],
                    'en' => ['name' => 'Lifestyle', 'description' => 'Lifestyle and living articles'],
                    'ja' => ['name' => 'ライフスタイル', 'description' => 'ライフスタイルと生活の記事'],
                    'ko' => ['name' => '라이프스타일', 'description' => '라이프스타일 및 생활 기사'],
                    'zh' => ['name' => '生活方式', 'description' => '生活方式和生活文章'],
                ]
            ],
            [
                'slug' => 'travel',
                'translations' => [
                    'vi' => ['name' => 'Du lịch', 'description' => 'Hướng dẫn và kinh nghiệm du lịch'],
                    'en' => ['name' => 'Travel', 'description' => 'Travel guides and experiences'],
                    'ja' => ['name' => '旅行', 'description' => '旅行ガイドと体験'],
                    'ko' => ['name' => '여행', 'description' => '여행 가이드 및 경험'],
                    'zh' => ['name' => '旅行', 'description' => '旅行指南和体验'],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'slug' => $categoryData['slug'],
                'is_active' => true,
                'sort_order' => 0
            ]);

            foreach ($categoryData['translations'] as $langCode => $translation) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'language_code' => $langCode,
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                    'seo_title' => $translation['name'],
                    'seo_description' => $translation['description']
                ]);
            }
        }
    }

    private function createTags()
    {
        $tags = [
            [
                'slug' => 'ai',
                'translations' => [
                    'vi' => ['name' => 'Trí tuệ nhân tạo', 'description' => 'Bài viết về AI'],
                    'en' => ['name' => 'Artificial Intelligence', 'description' => 'Articles about AI'],
                    'ja' => ['name' => '人工知能', 'description' => 'AIに関する記事'],
                    'ko' => ['name' => '인공지능', 'description' => 'AI에 관한 기사'],
                    'zh' => ['name' => '人工智能', 'description' => '关于AI的文章'],
                ]
            ],
            [
                'slug' => 'web-development',
                'translations' => [
                    'vi' => ['name' => 'Phát triển web', 'description' => 'Lập trình web'],
                    'en' => ['name' => 'Web Development', 'description' => 'Web programming'],
                    'ja' => ['name' => 'ウェブ開発', 'description' => 'ウェブプログラミング'],
                    'ko' => ['name' => '웹 개발', 'description' => '웹 프로그래밍'],
                    'zh' => ['name' => '网页开发', 'description' => '网页编程'],
                ]
            ]
        ];

        foreach ($tags as $tagData) {
            $tag = Tag::create([
                'slug' => $tagData['slug'],
                'is_active' => true
            ]);

            foreach ($tagData['translations'] as $langCode => $translation) {
                TagTranslation::create([
                    'tag_id' => $tag->id,
                    'language_code' => $langCode,
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                    'seo_title' => $translation['name'],
                    'seo_description' => $translation['description']
                ]);
            }
        }
    }

    private function createBlogs()
    {
        $category = Category::first();
        $tag = Tag::first();
        
        // Tạo blog group
        $blogGroup = BlogGroup::create();

        $blogContents = [
            'vi' => [
                'title' => 'Tương lai của Trí tuệ Nhân tạo trong Phát triển Web',
                'slug' => 'tuong-lai-cua-tri-tue-nhan-tao-trong-phat-trien-web',
                'excerpt' => 'Khám phá cách AI đang thay đổi cách chúng ta phát triển website và ứng dụng web.',
                'content' => '<h2>Giới thiệu</h2><p>Trí tuệ nhân tạo (AI) đang cách mạng hóa nhiều lĩnh vực, và phát triển web không phải là ngoại lệ. Trong bài viết này, chúng ta sẽ khám phá những cách thức mà AI đang thay đổi cách chúng ta xây dựng và tương tác với các trang web.</p><h2>AI trong Thiết kế Web</h2><p>Các công cụ AI hiện đại có thể tự động tạo ra các thiết kế web đẹp mắt và thân thiện với người dùng. Chúng phân tích hành vi người dùng và đề xuất các cải tiến để tối ưu hóa trải nghiệm.</p><h2>Tự động hóa Code</h2><p>AI có thể giúp các nhà phát triển viết code nhanh hơn và chính xác hơn thông qua các công cụ như GitHub Copilot và ChatGPT.</p>'
            ],
            'en' => [
                'title' => 'The Future of Artificial Intelligence in Web Development',
                'slug' => 'future-of-artificial-intelligence-in-web-development',
                'excerpt' => 'Explore how AI is changing the way we develop websites and web applications.',
                'content' => '<h2>Introduction</h2><p>Artificial Intelligence (AI) is revolutionizing many fields, and web development is no exception. In this article, we will explore the ways AI is changing how we build and interact with websites.</p><h2>AI in Web Design</h2><p>Modern AI tools can automatically create beautiful and user-friendly web designs. They analyze user behavior and suggest improvements to optimize the experience.</p><h2>Code Automation</h2><p>AI can help developers write code faster and more accurately through tools like GitHub Copilot and ChatGPT.</p>'
            ],
            'ja' => [
                'title' => 'ウェブ開発における人工知能の未来',
                'slug' => 'web-kaihatsu-ni-okeru-jinko-chino-no-mirai',
                'excerpt' => 'AIがウェブサイトやウェブアプリケーションの開発方法をどのように変えているかを探る。',
                'content' => '<h2>はじめに</h2><p>人工知能（AI）は多くの分野を革命化しており、ウェブ開発も例外ではありません。この記事では、AIがウェブサイトの構築と相互作用の方法をどのように変えているかを探ります。</p><h2>ウェブデザインにおけるAI</h2><p>現代のAIツールは、美しくユーザーフレンドリーなウェブデザインを自動的に作成できます。ユーザーの行動を分析し、体験を最適化するための改善を提案します。</p><h2>コードの自動化</h2><p>AIは、GitHub CopilotやChatGPTなどのツールを通じて、開発者がより速く、より正確にコードを書くのを支援できます。</p>'
            ]
        ];

        foreach ($blogContents as $langCode => $content) {
            $blog = Blog::create([
                'blog_group_id' => $blogGroup->id,
                'language_code' => $langCode,
                'category_id' => $category->id,
                'title' => $content['title'],
                'slug' => $content['slug'],
                'excerpt' => $content['excerpt'],
                'content' => $content['content'],
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => true,
                'allow_comments' => true,
                'view_count' => rand(100, 1000),
                'like_count' => rand(10, 100),
                'seo_title' => $content['title'],
                'seo_description' => $content['excerpt']
            ]);

            // Attach tags
            $blog->tags()->attach($tag->id);
        }
    }
}
