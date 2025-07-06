<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? __('app.blog_title') }}</title>
    <meta name="description" content="{{ $description ?? __('app.blog_description') }}">
    <meta name="keywords" content="{{ __('app.blog_keywords') }}">
    <meta name="author" content="{{ __('app.meta_author') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="http://wifiqr.net/blog">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="http://wifiqr.net/blog">
    <meta property="og:title" content="{{ __('app.blog_og_title') }}">
    <meta property="og:description" content="{{ __('app.blog_og_description') }}">
    <meta property="og:image" content="http://wifiqr.net/images/og-image.svg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://wifiqr.net/blog">
    <meta property="twitter:title" content="{{ __('app.blog_twitter_title') }}">
    <meta property="twitter:description" content="{{ __('app.blog_twitter_description') }}">
    <meta property="twitter:image" content="http://wifiqr.net/images/og-image.svg">

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="/images/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: #fbfbfd;
            color: #1d1d1f;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 22px;
        }

        .header {
            padding: 40px 0;
            text-align: center;
            background: #fbfbfd;
            border-bottom: 1px solid #f0f0f0;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1d1d1f;
        }

        .header p {
            font-size: 20px;
            color: #86868b;
            max-width: 600px;
            margin: 0 auto;
        }

        .nav {
            text-align: center;
            margin-top: 24px;
        }

        .nav a {
            color: #007aff;
            text-decoration: none;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 20px;
            background: #f0f8ff;
            transition: all 0.3s ease;
        }

        .nav a:hover {
            background: #007aff;
            color: white;
        }

        .content {
            padding: 80px 0;
            max-width: 800px;
            margin: 0 auto;
        }

        .article {
            background: white;
            border-radius: 18px;
            padding: 48px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .article h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #1d1d1f;
        }

        .article h3 {
            font-size: 24px;
            font-weight: 600;
            margin: 32px 0 16px;
            color: #1d1d1f;
        }

        .article p {
            margin-bottom: 16px;
            font-size: 17px;
            line-height: 1.6;
            color: #1d1d1f;
        }

        .article ul, .article ol {
            margin: 16px 0 16px 24px;
        }

        .article li {
            margin-bottom: 8px;
            font-size: 17px;
            line-height: 1.6;
        }

        .highlight {
            background: #f0f8ff;
            padding: 24px;
            border-radius: 12px;
            border-left: 4px solid #007aff;
            margin: 24px 0;
        }

        .highlight h4 {
            color: #007aff;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .code {
            background: #f5f5f7;
            padding: 16px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 14px;
            margin: 16px 0;
            overflow-x: auto;
        }

        .footer {
            background: #1d1d1f;
            color: #f5f5f7;
            padding: 48px 0;
            text-align: center;
        }

        .footer p {
            color: #86868b;
            margin-bottom: 16px;
        }

        .footer a {
            color: #007aff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 32px;
            }

            .article {
                padding: 24px;
            }

            .content {
                padding: 40px 0;
            }
        }
    </style>

    <!-- Schema.org structured data for article -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ __('app.blog_schema_headline') }}",
        "description": "{{ __('app.blog_schema_description') }}",
        "author": {
            "@type": "Organization",
            "name": "WiFi QR Generator"
        },
        "publisher": {
            "@type": "Organization",
            "name": "WiFi QR Generator",
            "logo": {
                "@type": "ImageObject",
                "url": "http://wifiqr.net/images/logo.svg"
            }
        },
        "datePublished": "2024-12-19",
        "dateModified": "2024-12-19",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "http://wifiqr.net/blog"
        },
        "image": "http://wifiqr.net/images/og-image.svg",
        "articleSection": "{{ __('app.blog_schema_section') }}",
        "keywords": ["WiFi QR Code", "QR Code Generator", "WiFi Access", "Business WiFi", "Restaurant WiFi", "Hotel WiFi"]
    }
    </script>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <!-- Language Selector -->
            <div style="position: absolute; top: 20px; right: 20px;">
                <select id="language-select" style="padding: 8px 12px; border: 1px solid #d2d2d7; border-radius: 8px; background: white; font-size: 14px;">
                    @foreach($supportedLanguages as $code => $info)
                        <option value="{{ $code }}" {{ $currentLocale === $code ? 'selected' : '' }}>
                            {{ $info['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <h1>{{ __('app.blog_h1') }}</h1>
            <p>{{ __('app.blog_subtitle') }}</p>
            <div class="nav">
                <a href="/">{{ __('app.nav_back_to_generator') }}</a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <article class="article">
                <h2>{{ __('app.blog_h1') }}</h2>

                <p>{{ __('app.blog_intro') }}</p>

                <h3>{{ __('app.blog_what_are_title') }}</h3>
                <p>{{ __('app.blog_what_are_content') }}</p>

                <div class="highlight">
                    <h4>{{ __('app.blog_pro_tip') }}</h4>
                    <p>{{ __('app.blog_pro_tip_content') }}</p>
                </div>

                <h3>{{ __('app.blog_how_create_title') }}</h3>
                <ol>
                    <li><strong>{{ __('app.blog_step1') }}</strong></li>
                    <li><strong>{{ __('app.blog_step2') }}</strong></li>
                    <li><strong>{{ __('app.blog_step3') }}</strong></li>
                    <li><strong>{{ __('app.blog_step4') }}</strong></li>
                </ol>

                <h3>{{ __('app.blog_best_practices_title') }}</h3>

                <h4>{{ __('app.blog_restaurants_title') }}</h4>
                <ul>
                    <li>{{ __('app.blog_restaurants_tip1') }}</li>
                    <li>{{ __('app.blog_restaurants_tip2') }}</li>
                    <li>{{ __('app.blog_restaurants_tip3') }}</li>
                    <li>{{ __('app.blog_restaurants_tip4') }}</li>
                </ul>

                <h4>{{ __('app.blog_hotels_title') }}</h4>
                <ul>
                    <li>{{ __('app.blog_hotels_tip1') }}</li>
                    <li>{{ __('app.blog_hotels_tip2') }}</li>
                    <li>{{ __('app.blog_hotels_tip3') }}</li>
                    <li>{{ __('app.blog_hotels_tip4') }}</li>
                </ul>

                <h4>{{ __('app.blog_offices_title') }}</h4>
                <ul>
                    <li>{{ __('app.blog_offices_tip1') }}</li>
                    <li>{{ __('app.blog_offices_tip2') }}</li>
                    <li>{{ __('app.blog_offices_tip3') }}</li>
                    <li>{{ __('app.blog_offices_tip4') }}</li>
                </ul>

                <h3>{{ __('app.blog_security_title') }}</h3>
                <ul>
                    <li>{{ __('app.blog_security_tip1') }}</li>
                    <li>{{ __('app.blog_security_tip2') }}</li>
                    <li>{{ __('app.blog_security_tip3') }}</li>
                    <li>{{ __('app.blog_security_tip4') }}</li>
                </ul>

                <div class="highlight">
                    <h4>{{ __('app.blog_security_tip_title') }}</h4>
                    <p>{{ __('app.blog_security_tip_content') }}</p>
                </div>

                <h3>{{ __('app.blog_technical_title') }}</h3>
                <p>{{ __('app.blog_technical_intro') }}</p>
                <div class="code">{{ __('app.blog_technical_format') }}</div>
                <p>{{ __('app.blog_technical_where') }}</p>
                <ul>
                    <li><strong>{{ __('app.blog_technical_t') }}</strong></li>
                    <li><strong>{{ __('app.blog_technical_s') }}</strong></li>
                    <li><strong>{{ __('app.blog_technical_p') }}</strong></li>
                </ul>

                <h3>{{ __('app.blog_troubleshooting_title') }}</h3>
                <ul>
                    <li><strong>{{ __('app.blog_trouble_scan') }}</strong></li>
                    <li><strong>{{ __('app.blog_trouble_connection') }}</strong></li>
                    <li><strong>{{ __('app.blog_trouble_older') }}</strong></li>
                    <li><strong>{{ __('app.blog_trouble_special') }}</strong></li>
                </ul>

                <h3>{{ __('app.blog_measuring_title') }}</h3>
                <p>{{ __('app.blog_measuring_intro') }}</p>
                <ul>
                    <li>{{ __('app.blog_measuring_analytics') }}</li>
                    <li>{{ __('app.blog_measuring_surveys') }}</li>
                    <li>{{ __('app.blog_measuring_requests') }}</li>
                    <li>{{ __('app.blog_measuring_engagement') }}</li>
                </ul>

                <div class="highlight">
                    <h4>{{ __('app.blog_cta_title') }}</h4>
                    <p><a href="/" style="color: #007aff; text-decoration: none; font-weight: 600;">{{ __('app.blog_cta_content') }}</a></p>
                </div>
            </article>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p>{{ __('app.blog_footer_text1') }}</p>
                <p>{{ __('app.blog_footer_text2') }}</p>
            </div>
        </footer>
    </div>

    <script>
        // Language switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const languageSelect = document.getElementById('language-select');

            if (languageSelect) {
                languageSelect.addEventListener('change', function() {
                    const selectedLocale = this.value;

                    // Send AJAX request to change language
                    fetch('/set-language', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            locale: selectedLocale
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to apply new language
                            window.location.reload();
                        } else {
                            console.error('Failed to change language:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Language change error:', error);
                    });
                });
            }
        });
    </script>
</body>
</html>
