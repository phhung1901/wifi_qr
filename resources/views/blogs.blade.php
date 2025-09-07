<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? __('app.blogs_title') }}</title>
    <meta name="description" content="{{ $description ?? __('app.blogs_description') }}">
    <meta name="keywords" content="{{ $keywords ?? __('app.blogs_keywords') }}">
    <meta name="author" content="{{ __('app.meta_author') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/blogs') }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $title ?? __('app.blogs_title') }}">
    <meta property="og:description" content="{{ $description ?? __('app.blogs_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/blogs') }}">
    <meta property="og:image" content="{{ asset('images/og-blogs.jpg') }}">
    <meta property="og:site_name" content="WiFi QR Generator">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? __('app.blogs_title') }}">
    <meta name="twitter:description" content="{{ $description ?? __('app.blogs_description') }}">
    <meta name="twitter:image" content="{{ asset('images/twitter-blogs.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: #ffffff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: white;
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 32px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .nav-breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            opacity: 0.8;
        }

        .nav-breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .nav-breadcrumb a:hover {
            opacity: 1;
        }

        /* Language Selector */
        .language-selector {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
        }

        .language-selector select {
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .language-selector select option {
            background: #1a1a1a;
            color: white;
        }

        /* Main Content */
        .main-content {
            padding: 80px 0;
        }

        /* Featured Section */
        .featured-section {
            margin-bottom: 80px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
            color: #1a1a1a;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 32px;
            margin-bottom: 60px;
        }

        /* Blog Cards */
        .blog-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .blog-card.featured {
            border: 2px solid #000;
        }

        .blog-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-content {
            padding: 24px;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 12px;
            color: #666;
        }

        .blog-category {
            background: #000;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .blog-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .blog-excerpt {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .blog-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .read-more {
            color: #000;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: gap 0.2s;
        }

        .read-more:hover {
            gap: 8px;
        }

        .blog-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: #999;
        }

        /* Filter Section */
        .filter-section {
            background: #f8f9fa;
            padding: 32px 0;
            margin-bottom: 60px;
            border-radius: 16px;
        }

        .filter-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .category-filter {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #666;
            border-radius: 24px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .category-btn:hover,
        .category-btn.active {
            border-color: #000;
            background: #000;
            color: white;
        }

        /* Blog Grid */
        .blogs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
            margin-bottom: 60px;
        }

        /* Load More */
        .load-more {
            text-align: center;
        }

        .load-more-btn {
            background: #000;
            color: white;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .load-more-btn:hover {
            background: #333;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 12px;
            color: #1a1a1a;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 36px;
            }

            .header p {
                font-size: 18px;
            }

            .featured-grid,
            .blogs-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .filter-content {
                flex-direction: column;
                gap: 16px;
            }

            .main-content {
                padding: 40px 0;
            }

            .language-selector {
                position: static;
                margin-bottom: 20px;
                text-align: center;
            }
        }
    </style>

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "{{ __('app.blogs_title') }}",
        "description": "{{ __('app.blogs_description') }}",
        "url": "{{ url('/blogs') }}",
        "publisher": {
            "@type": "Organization",
            "name": "WiFi QR Generator",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.svg') }}"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url('/blogs') }}"
        }
    }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Language Selector -->
        <div class="language-selector">
            <select id="language-select">
                @foreach($supportedLanguages as $code => $info)
                    <option value="{{ $code }}" {{ $currentLocale === $code ? 'selected' : '' }}>
                        {{ $info['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="container">
            <div class="header-content">
                <h1>{{ __('app.blogs_h1') }}</h1>
                <p>{{ __('app.blogs_subtitle') }}</p>
                <nav class="nav-breadcrumb">
                    <a href="/">{{ __('app.nav_home') }}</a>
                    <span>→</span>
                    <span>{{ __('app.blogs_h1') }}</span>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @if($featuredBlogs && $featuredBlogs->count() > 0)
            <!-- Featured Section -->
            <section class="featured-section">
                <h2 class="section-title">{{ __('app.blogs_featured_title') }}</h2>
                <div class="featured-grid">
                    @foreach($featuredBlogs as $blog)
                    <article class="blog-card featured">
                        <div class="blog-image">
                            @if($blog->featured_image)
                                <img src="{{ $blog->featured_image }}" alt="{{ $blog->featured_image_alt ?? $blog->title }}" loading="lazy">
                            @else
                                <span>{{ __('app.no_image') }}</span>
                            @endif
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="blog-category">
                                    @if($blog->category && $blog->category->translations->count() > 0)
                                        {{ $blog->category->translations->first()->name }}
                                    @else
                                        {{ $blog->category->name ?? 'General' }}
                                    @endif
                                </span>
                                <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}</span>
                            </div>
                            <h3 class="blog-title">{{ $blog->title }}</h3>
                            <p class="blog-excerpt">{{ Str::limit($blog->excerpt, 120) }}</p>
                            <div class="blog-footer">
                                <a href="{{ url('/blog/' . $blog->slug) }}" class="read-more">
                                    {{ __('app.blogs_read_more') }} →
                                </a>
                                <div class="blog-stats">
                                    <span>👁 {{ number_format($blog->view_count) }}</span>
                                    <span>❤️ {{ number_format($blog->like_count) }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Filter Section -->
            <section class="filter-section">
                <div class="container">
                    <div class="filter-content">
                        <span>{{ __('app.blogs_filter_by_category') }}:</span>
                        <div class="category-filter">
                            <a href="{{ route('blogs') }}" class="category-btn {{ !$selectedCategory ? 'active' : '' }}">
                                {{ __('app.blogs_all_categories') }}
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('blogs', ['category_id' => $category->id]) }}"
                                   class="category-btn {{ $selectedCategory == $category->id ? 'active' : '' }}">
                                    {{ $category->translations->first()->name ?? $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Latest Blogs Section -->
            <section class="blogs-section">
                <h2 class="section-title">{{ __('app.blogs_latest_title') }}</h2>

                @if($blogs && $blogs->count() > 0)
                <div class="blogs-grid">
                    @foreach($blogs as $blog)
                    <article class="blog-card">
                        <div class="blog-image">
                            @if($blog->featured_image)
                                <img src="{{ $blog->featured_image }}" alt="{{ $blog->featured_image_alt ?? $blog->title }}" loading="lazy">
                            @else
                                <span>{{ __('app.no_image') }}</span>
                            @endif
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="blog-category">
                                    @if($blog->category && $blog->category->translations->count() > 0)
                                        {{ $blog->category->translations->first()->name }}
                                    @else
                                        {{ $blog->category->name ?? 'General' }}
                                    @endif
                                </span>
                                <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}</span>
                            </div>
                            <h3 class="blog-title">{{ $blog->title }}</h3>
                            <p class="blog-excerpt">{{ Str::limit($blog->excerpt, 120) }}</p>
                            <div class="blog-footer">
                                <a href="{{ url('/blog/' . $blog->slug) }}" class="read-more">
                                    {{ __('app.blogs_read_more') }} →
                                </a>
                                <div class="blog-stats">
                                    <span>👁 {{ number_format($blog->view_count) }}</span>
                                    <span>❤️ {{ number_format($blog->like_count) }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                <div class="load-more">
                    {{ $blogs->links() }}
                </div>
                @endif
                @else
                <div class="empty-state">
                    <h3>{{ __('app.blogs_no_posts') }}</h3>
                    <p>{{ __('app.check_back_later') }}</p>
                </div>
                @endif
            </section>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        // Language selector
        document.getElementById('language-select').addEventListener('change', function() {
            const locale = this.value;

            fetch('/set-language', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ locale: locale })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation for images
        document.querySelectorAll('.blog-image img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    </script>
</body>
</html>
