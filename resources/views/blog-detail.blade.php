<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? $blog->title }}</title>
    <meta name="description" content="{{ $description ?? $blog->excerpt }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ __('app.meta_author') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/blog/' . $blog->slug) }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $title ?? $blog->title }}">
    <meta property="og:description" content="{{ $description ?? $blog->excerpt }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url('/blog/' . $blog->slug) }}">
    @if($blog->featured_image)
    <meta property="og:image" content="{{ $blog->featured_image }}">
    @endif
    <meta property="og:site_name" content="WiFi QR Generator">
    <meta property="article:published_time" content="{{ $blog->published_at ? $blog->published_at->toISOString() : '' }}">
    <meta property="article:author" content="{{ __('app.meta_author') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? $blog->title }}">
    <meta name="twitter:description" content="{{ $description ?? $blog->excerpt }}">
    @if($blog->featured_image)
    <meta name="twitter:image" content="{{ $blog->featured_image }}">
    @endif

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
            line-height: 1.7;
            color: #1a1a1a;
            background: #ffffff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: white;
            padding: 40px 0;
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
        }

        .nav-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .nav-breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .nav-breadcrumb a:hover {
            opacity: 1;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
            font-size: 14px;
            opacity: 0.9;
        }

        .blog-category {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 16px;
            font-weight: 500;
        }

        .blog-title {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blog-excerpt {
            font-size: 18px;
            opacity: 0.9;
            line-height: 1.6;
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
            padding: 60px 0;
        }

        .blog-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-content {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
        }

        .blog-content h1,
        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            color: #1a1a1a;
            margin: 32px 0 16px 0;
            font-weight: 600;
        }

        .blog-content h1 { font-size: 32px; }
        .blog-content h2 { font-size: 28px; }
        .blog-content h3 { font-size: 24px; }
        .blog-content h4 { font-size: 20px; }

        .blog-content p {
            margin-bottom: 20px;
        }

        .blog-content ul,
        .blog-content ol {
            margin: 20px 0;
            padding-left: 24px;
        }

        .blog-content li {
            margin-bottom: 8px;
        }

        .blog-content blockquote {
            border-left: 4px solid #000;
            padding: 16px 24px;
            margin: 24px 0;
            background: #f8f9fa;
            font-style: italic;
            color: #555;
        }

        .blog-content code {
            background: #f1f3f4;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 14px;
        }

        .blog-content pre {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
        }

        .blog-content a {
            color: #000;
            text-decoration: underline;
            transition: opacity 0.2s;
        }

        .blog-content a:hover {
            opacity: 0.7;
        }

        /* Blog Stats */
        .blog-stats {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 24px 0;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            margin: 40px 0;
            font-size: 14px;
            color: #666;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Related Blogs */
        .related-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 2px solid #f0f0f0;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 32px;
            color: #1a1a1a;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .related-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .related-image {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
        }

        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-content {
            padding: 16px;
        }

        .related-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .related-excerpt {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .related-link {
            text-decoration: none;
            color: inherit;
        }

        /* Back to Blogs */
        .back-to-blogs {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 40px;
            transition: gap 0.2s;
        }

        .back-to-blogs:hover {
            gap: 12px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .blog-title {
                font-size: 28px;
            }

            .blog-image {
                height: 250px;
            }

            .main-content {
                padding: 40px 0;
            }

            .blog-stats {
                flex-wrap: wrap;
                gap: 16px;
            }

            .related-grid {
                grid-template-columns: 1fr;
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
        "@type": "Article",
        "headline": "{{ $blog->title }}",
        "description": "{{ $blog->excerpt }}",
        "author": {
            "@type": "Organization",
            "name": "WiFi QR Generator"
        },
        "publisher": {
            "@type": "Organization",
            "name": "WiFi QR Generator",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.svg') }}"
            }
        },
        "datePublished": "{{ $blog->published_at ? $blog->published_at->toISOString() : '' }}",
        "dateModified": "{{ $blog->updated_at ? $blog->updated_at->toISOString() : '' }}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url('/blog/' . $blog->slug) }}"
        }
        @if($blog->featured_image)
        ,"image": {
            "@type": "ImageObject",
            "url": "{{ $blog->featured_image }}",
            "width": 1200,
            "height": 630
        }
        @endif
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
                <nav class="nav-breadcrumb">
                    <a href="/">{{ __('app.nav_home') }}</a>
                    <span>→</span>
                    <a href="{{ route('blogs') }}">{{ __('app.blogs_h1') }}</a>
                    <span>→</span>
                    <span>{{ $blog->title }}</span>
                </nav>

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

                <h1 class="blog-title">{{ $blog->title }}</h1>
                
                @if($blog->excerpt)
                <p class="blog-excerpt">{{ $blog->excerpt }}</p>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <a href="{{ route('blogs') }}" class="back-to-blogs">
                ← {{ __('app.back_to_blogs') }}
            </a>

            @if($blog->featured_image)
            <div class="blog-image">
                <img src="{{ $blog->featured_image }}" alt="{{ $blog->featured_image_alt ?? $blog->title }}" loading="lazy">
            </div>
            @endif

            <div class="blog-stats">
                <div class="stat-item">
                    <span>👁</span>
                    <span>{{ number_format($blog->view_count) }} {{ __('app.views') }}</span>
                </div>
                <div class="stat-item">
                    <span>❤️</span>
                    <span>{{ number_format($blog->like_count) }} {{ __('app.likes') }}</span>
                </div>
                @if($blog->allow_comments)
                <div class="stat-item">
                    <span>💬</span>
                    <span>{{ number_format($blog->comment_count) }} {{ __('app.comments') }}</span>
                </div>
                @endif
                <div class="stat-item">
                    <span>📅</span>
                    <span>{{ $blog->published_at ? $blog->published_at->format('F j, Y') : 'Draft' }}</span>
                </div>
            </div>

            <article class="blog-content">
                {!! $blog->content !!}
            </article>

            @if($relatedBlogs && $relatedBlogs->count() > 0)
            <section class="related-section">
                <h2 class="section-title">{{ __('app.related_articles') }}</h2>
                <div class="related-grid">
                    @foreach($relatedBlogs as $relatedBlog)
                    <a href="{{ url('/blog/' . $relatedBlog->slug) }}" class="related-link">
                        <article class="related-card">
                            <div class="related-image">
                                @if($relatedBlog->featured_image)
                                    <img src="{{ $relatedBlog->featured_image }}" alt="{{ $relatedBlog->featured_image_alt ?? $relatedBlog->title }}" loading="lazy">
                                @else
                                    <span>{{ __('app.no_image') }}</span>
                                @endif
                            </div>
                            <div class="related-content">
                                <h3 class="related-title">{{ $relatedBlog->title }}</h3>
                                <p class="related-excerpt">{{ Str::limit($relatedBlog->excerpt, 80) }}</p>
                            </div>
                        </article>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif
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
    </script>
</body>
</html>
