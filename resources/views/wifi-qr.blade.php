<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? __('app.site_title') }}</title>
    <meta name="description" content="{{ $description ?? __('app.site_description') }}">
    <meta name="keywords" content="{{ $keywords ?? 'wifi qr code generator, free wifi qr code, qr code for wifi, wifi password qr code, custom wifi qr, wifi qr generator, qr code wifi password, wifi qr code maker, generate wifi qr code, wifi qr code with logo, instant wifi connection, wifi sharing qr, restaurant wifi qr, hotel wifi qr, office wifi qr' }}">
    <meta name="author" content="{{ __('app.meta_author') }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="http://wifiqr.net">

    <meta name="google-site-verification" content="HGTv3wF8o3sh382rYuRxm-JV5phN_3G3xJRdAwuUNgs" />

    <!-- Multilingual Hreflang Tags -->
    <link rel="alternate" hreflang="en" href="http://wifiqr.net/" />
    <link rel="alternate" hreflang="es" href="http://wifiqr.net/es/" />
    <link rel="alternate" hreflang="fr" href="http://wifiqr.net/fr/" />
    <link rel="alternate" hreflang="de" href="http://wifiqr.net/de/" />
    <link rel="alternate" hreflang="zh" href="http://wifiqr.net/zh/" />
    <link rel="alternate" hreflang="ja" href="http://wifiqr.net/ja/" />
    <link rel="alternate" hreflang="ko" href="http://wifiqr.net/ko/" />
    <link rel="alternate" hreflang="vi" href="http://wifiqr.net/vi/" />
    <link rel="alternate" hreflang="hi" href="http://wifiqr.net/hi/" />
    <link rel="alternate" hreflang="id" href="http://wifiqr.net/id/" />
    <link rel="alternate" hreflang="x-default" href="http://wifiqr.net/" />

    <!-- Additional SEO Meta Tags -->
    <meta name="geo.region" content="{{ __('app.meta_geo_region') }}">
    <meta name="geo.placename" content="{{ __('app.meta_geo_placename') }}">
    <meta name="language" content="{{ $currentLocale ?? 'en' }}">
    <meta name="distribution" content="{{ __('app.meta_distribution') }}">
    <meta name="rating" content="{{ __('app.meta_rating') }}">
    <meta name="revisit-after" content="7 days">
    <meta name="classification" content="{{ __('app.meta_classification') }}">
    <meta name="category" content="{{ __('app.meta_category') }}">
    <meta name="coverage" content="{{ __('app.meta_coverage') }}">
    <meta name="target" content="{{ __('app.meta_target') }}">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "{{ __('app.schema_app_name') }}",
        "alternateName": "{{ __('app.schema_app_alt_name') }}",
        "description": "{{ __('app.schema_app_description') }}",
        "url": "http://wifiqr.net",
        "applicationCategory": "{{ __('app.schema_app_category') }}",
        "operatingSystem": "{{ __('app.schema_operating_system') }}",
        "permissions": "{{ __('app.schema_permissions') }}",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "featureList": [
            "{{ __('app.schema_feature_1') }}",
            "{{ __('app.schema_feature_2') }}",
            "{{ __('app.schema_feature_3') }}",
            "{{ __('app.schema_feature_4') }}",
            "{{ __('app.schema_feature_5') }}",
            "{{ __('app.schema_feature_6') }}"
        ],
        "screenshot": "http://wifiqr.net/images/og-image.svg",
        "softwareVersion": "1.0",
        "datePublished": "2024-12-19",
        "dateModified": "2024-12-19",
        "author": {
            "@type": "Organization",
            "name": "{{ __('app.schema_app_name') }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ __('app.schema_app_name') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "http://wifiqr.net/images/logo.svg"
            }
        }
    }
    </script>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ __('app.og_type') }}">
    <meta property="og:url" content="http://wifiqr.net">
    <meta property="og:title" content="{{ $title ?? __('app.site_title') }}">
    <meta property="og:description" content="{{ $description ?? __('app.site_description') }}">
    <meta property="og:image" content="http://wifiqr.net/images/og-image.svg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ __('app.og_image_alt') }}">
    <meta property="og:site_name" content="{{ __('app.og_site_name') }}">
    <meta property="og:locale" content="{{ __('app.og_locale') }}">
    <meta property="article:author" content="{{ __('app.og_article_author') }}">
    <meta property="article:section" content="{{ __('app.og_article_section') }}">
    <meta property="article:tag" content="{{ __('app.og_article_tag') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="{{ __('app.twitter_card') }}">
    <meta property="twitter:url" content="http://wifiqr.net">
    <meta property="twitter:title" content="{{ $title ?? __('app.site_title') }}">
    <meta property="twitter:description" content="{{ $description ?? __('app.site_description') }}">
    <meta property="twitter:image" content="http://wifiqr.net/images/og-image.svg">
    <meta property="twitter:image:alt" content="{{ __('app.twitter_image_alt') }}">
    <meta property="twitter:site" content="{{ __('app.twitter_site') }}">
    <meta property="twitter:creator" content="{{ __('app.twitter_creator') }}">

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="/images/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#667eea">

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
            line-height: 1.47059;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-weight: 400;
            letter-spacing: -0.022em;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 22px;
        }

        /* Header */
        .header {
            padding: 88px 0 108px;
            text-align: center;
            background: #fbfbfd;
        }

        .logo-container {
            margin-bottom: 24px;
        }

        .header-logo {
            height: 60px;
            width: auto;
            max-width: 280px;
            transition: all 0.3s ease;
        }

        .header-logo:hover {
            transform: scale(1.05);
        }

        .header h1 {
            font-size: 56px;
            line-height: 1.07143;
            font-weight: 600;
            letter-spacing: -0.005em;
            margin-bottom: 6px;
            color: #1d1d1f;
        }

        .header p {
            font-size: 28px;
            line-height: 1.14286;
            font-weight: 400;
            letter-spacing: 0.007em;
            color: #86868b;
            max-width: 980px;
            margin: 0 auto;
        }

        /* Main Content */
        .main {
            padding: 80px 0;
        }

        .form-section {
            background: #ffffff;
            border-radius: 18px;
            padding: 48px;
            margin-bottom: 40px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            font-size: 17px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #d2d2d7;
            border-radius: 12px;
            font-size: 17px;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #0071e3;
            box-shadow: 0 0 0 4px rgba(0, 125, 250, 0.6);
        }

        .form-input:hover {
            border-color: #86868b;
        }

        .form-input::placeholder {
            color: #86868b;
        }

        .form-input select,
        select.form-input {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 48px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 16px;
        }

        .custom-group .checkbox-group {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f5f5f7;
        }

        /* Password Input Container */
        .password-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-container .form-input {
            padding-right: 50px;
            flex: 1;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            z-index: 1;
        }

        .password-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .password-toggle-icon {
            font-size: 16px;
            user-select: none;
        }

        /* Password Requirements */
        .password-requirements {
            margin-top: 8px;
            padding: 12px;
            background: rgba(0, 122, 255, 0.05);
            border-radius: 8px;
            border-left: 3px solid #007aff;
        }

        .requirement {
            color: #86868b;
            font-size: 13px;
            transition: color 0.2s ease;
        }

        .requirement.valid {
            color: #34c759;
        }

        .requirement.invalid {
            color: #ff3b30;
        }

        /* Input validation states */
        .form-input.valid {
            border-color: #34c759;
            box-shadow: 0 0 0 3px rgba(52, 199, 89, 0.1);
        }

        .form-input.invalid {
            border-color: #ff3b30;
            box-shadow: 0 0 0 3px rgba(255, 59, 48, 0.1);
        }

        .checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: #007aff;
        }

        .checkbox-label {
            font-size: 15px;
            color: #86868b;
            cursor: pointer;
        }

        .btn-primary {
            background: #0071e3;
            color: #ffffff;
            border: none;
            padding: 16px 32px;
            border-radius: 980px;
            font-size: 17px;
            line-height: 1.23536;
            font-weight: 400;
            letter-spacing: -0.022em;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            width: 100%;
            margin-top: 24px;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background: #0077ed;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 125, 250, 0.4);
        }

        .btn-primary:active {
            background: #006edb;
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 125, 250, 0.3);
        }

        /* QR Section */
        .qr-section {
            display: none;
            text-align: center;
            background: #ffffff;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .qr-section:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .qr-container {
            background: white;
            border-radius: 16px;
            padding: 32px;
            display: inline-block;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 32px;
        }

        .qr-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1d1d1f;
            text-align: center;
        }

        .qr-subtitle {
            font-size: 17px;
            color: #86868b;
            margin-bottom: 32px;
            text-align: center;
        }

        .wifi-info {
            background: rgba(0, 122, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
            text-align: center;
        }

        .wifi-info p {
            margin: 4px 0;
            font-size: 15px;
            color: #1d1d1f;
        }

        /* Customization Panel */
        .customization-panel {
            display: none;
            background: #ffffff;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .customization-panel:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .panel-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 32px;
            text-align: center;
            color: #1d1d1f;
        }

        .customization-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .customization-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        .custom-group {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #f5f5f7;
        }

        .custom-group h3 {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1d1d1f;
        }

        .color-input {
            width: 100%;
            height: 48px;
            border: 2px solid #d2d2d7;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-input:hover {
            border-color: #007aff;
        }

        .range-input {
            width: 100%;
            margin: 16px 0;
            accent-color: #007aff;
        }

        .range-value {
            font-size: 15px;
            color: #86868b;
            text-align: center;
            margin-top: 8px;
        }

        .logo-upload {
            border: 2px dashed #d2d2d7;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .logo-upload:hover {
            border-color: #007aff;
            background: #f0f8ff;
        }

        .logo-upload.has-logo {
            border-style: solid;
            border-color: #007aff;
            background: #f0f8ff;
        }

        .logo-preview {
            max-width: 80px;
            max-height: 80px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .upload-text {
            font-size: 17px;
            color: #86868b;
            margin-bottom: 8px;
        }

        .upload-hint {
            font-size: 13px;
            color: #86868b;
        }

        /* Download Section */
        .download-section {
            display: none;
            text-align: center;
            background: #fbfbfd;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid #f5f5f7;
        }

        .download-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 32px;
        }

        .btn-download {
            background: #1d1d1f;
            color: #ffffff;
            border: none;
            padding: 16px 24px;
            border-radius: 980px;
            font-size: 17px;
            line-height: 1.23536;
            font-weight: 400;
            letter-spacing: -0.022em;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-download:hover {
            background: #424245;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(29, 29, 31, 0.4);
        }

        .btn-download.secondary {
            background: #ffffff;
            color: #1d1d1f;
            border: 1px solid #d2d2d7;
        }

        .btn-download.secondary:hover {
            border-color: #86868b;
            background: #f5f5f7;
        }

        /* Grid Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
            align-items: flex-start;
        }

        .col-lg-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }

        /* QR Section Adjustments */
        .qr-section {
            display: block;
            margin-bottom: 0;
            height: auto;
        }

        .qr-container {
            max-width: 100%;
            margin: 0 auto 24px;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-container canvas {
            max-width: 100%;
            height: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 40px;
            }

            .header p {
                font-size: 19px;
            }

            .row {
                flex-direction: column;
            }

            .col-lg-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }

            .form-section,
            .qr-section,
            .customization-panel,
            .download-section {
                padding: 24px 20px;
            }

            .customization-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .qr-container {
                min-height: 200px;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background: #ff3b30;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }

        .success-message {
            background: #34c759;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }

        .info-message {
            background: #007aff;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }

        /* Statistics Section Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        @keyframes countUp {
            from { transform: scale(1.02); }
            to { transform: scale(1); }
        }

        .stats-counter-animate {
            animation: countUp 0.3s ease-out;
        }

        /* Smooth number transitions */
        #stats-counter {
            transition: all 0.2s ease-out;
        }

        /* Responsive stats */
        @media (max-width: 768px) {
            #stats-counter {
                font-size: 36px !important;
            }
            .stats-section {
                padding: 30px 15px !important;
                margin: 0 15px 30px 15px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header" role="banner">
            <div class="logo-container">
                <img src="/images/logo-text.svg" alt="{{ __('app.site_title') }}" class="header-logo">
            </div>

            <!-- Language Selector -->
            <div class="language-selector" style="position: absolute; top: 20px; right: 20px;">
                <select id="language-select" style="padding: 8px 12px; border: 1px solid #d2d2d7; border-radius: 8px; background: white; font-size: 14px;">
                    @foreach($supportedLanguages as $code => $info)
                        <option value="{{ $code }}" {{ $currentLocale === $code ? 'selected' : '' }}>
                            {{ $info['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <h1>{{ __('app.header_title') }}</h1>
            <p>{{ __('app.header_subtitle') }}</p>
        </header>

        <!-- Statistics Section -->
        <section class="stats-section" style="text-align: center; padding: 40px 20px; margin-bottom: 40px; background: linear-gradient(135deg, #1d1d1f 0%, #2d2d30 100%); border-radius: 20px; margin: 0 20px 40px 20px; position: relative; overflow: hidden;">
            <!-- Background Animation -->
            <div class="stats-bg-animation" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1;">
                <div style="position: absolute; width: 100px; height: 100px; background: radial-gradient(circle, #007aff 0%, transparent 70%); border-radius: 50%; animation: float 6s ease-in-out infinite; top: 20%; left: 10%;"></div>
                <div style="position: absolute; width: 60px; height: 60px; background: radial-gradient(circle, #34c759 0%, transparent 70%); border-radius: 50%; animation: float 8s ease-in-out infinite reverse; top: 60%; right: 15%;"></div>
                <div style="position: absolute; width: 80px; height: 80px; background: radial-gradient(circle, #ff9500 0%, transparent 70%); border-radius: 50%; animation: float 7s ease-in-out infinite; bottom: 20%; left: 20%;"></div>
            </div>

            <div style="max-width: 700px; margin: 0 auto; position: relative; z-index: 2;">
                <div style="margin-bottom: 16px;">
                    <span style="font-size: 14px; color: #8e8e93; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">{{ __('app.stats_label') }}</span>
                </div>

                <div style="margin-bottom: 20px;">
                    <span id="stats-counter" style="font-size: 48px; color: #ffffff; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; text-shadow: 0 2px 10px rgba(0,0,0,0.3);" data-target="{{ $currentStats ?? 1000000 }}">
                        {{ number_format($currentStats ?? 1000000) }}
                    </span>
                </div>

                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <div class="pulse-indicator" style="width: 8px; height: 8px; background: #34c759; border-radius: 50%; animation: pulse 2s infinite;"></div>
                    <span style="font-size: 16px; color: #a1a1a6; font-weight: 500;">{{ __('app.stats_subtitle') }}</span>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="main" role="main">
            <!-- Main Content Grid -->
            <div class="row">
                <!-- Left Column: Form -->
                <div class="col-lg-6">
                    <!-- WiFi Form -->
                    <section class="form-section" aria-labelledby="wifi-form-title">
                        <h2 id="wifi-form-title" style="font-size: 24px; font-weight: 600; margin-bottom: 24px; color: #1d1d1f;">{{ __('app.wifi_details_title') }}</h2>
                        <form id="wifi-form" role="form" aria-label="WiFi QR Code Generator Form">
                            <div class="form-group">
                                <label for="ssid" class="form-label">{{ __('app.network_name_label') }}</label>
                                <input type="text" id="ssid" class="form-input" placeholder="{{ __('app.network_name_placeholder') }}" required aria-describedby="ssid-help">
                                <small id="ssid-help" style="color: #86868b; font-size: 13px;">{{ __('app.network_name_help') }}</small>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('app.password_label') }}</label>
                                <div class="password-input-container">
                                    <input type="password" id="password" class="form-input" placeholder="{{ __('app.password_placeholder') }}" minlength="8">
                                    <button type="button" id="toggle-password" class="password-toggle" aria-label="{{ __('app.password_toggle_aria') }}">
                                        <span class="password-toggle-icon">👁️</span>
                                    </button>
                                </div>
                                <div class="password-requirements" id="password-requirements" style="display: none;">
                                    <small>
                                        <span id="length-check" class="requirement">{{ __('app.password_length_check') }}</span><br>
                                        <span id="char-check" class="requirement">{{ __('app.password_char_check') }}</span>
                                    </small>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="no-password" class="checkbox">
                                    <label for="no-password" class="checkbox-label">{{ __('app.no_password_label') }}</label>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary">{{ __('app.generate_button') }}</button>
                        </form>
                    </section>
                </div>

                <!-- Right Column: QR Preview -->
                <div class="col-lg-6">
                    <section id="qr-section" class="qr-section" style="display: block;">
                        <h2 class="qr-title">{{ __('app.qr_title') }}</h2>
                        <p class="qr-subtitle">{{ __('app.qr_subtitle') }}</p>

                        <div class="qr-container">
                            <div id="qr-code">
                                <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: #86868b; flex-direction: column;">
                                    <div style="font-size: 48px; margin-bottom: 16px;">📱</div>
                                    <div>{{ __('app.qr_placeholder') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="wifi-info" id="wifi-info" style="display: none;">
                            <p><strong>{{ __('app.network_label') }}</strong> <span id="display-ssid"></span></p>
                            <p><strong>{{ __('app.security_label') }}</strong> <span id="display-security"></span></p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Customization Panel - Below the grid -->
            <section id="customization-panel" class="customization-panel" style="display: block;">
                <h2 class="panel-title">{{ __('app.customize_title') }}</h2>
                <p style="text-align: center; color: #86868b; margin-bottom: 32px;">{{ __('app.customize_subtitle') }}</p>

                <div class="customization-grid">
                    <!-- Colors & Style -->
                    <div class="custom-group">
                        <h3>{{ __('app.colors_style_title') }}</h3>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.foreground_color_label') }}</label>
                            <input type="color" id="fg-color" class="color-input" value="#000000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.qr_size_label') }}</label>
                            <input type="range" id="qr-size" class="range-input" min="200" max="400" value="300">
                            <div class="range-value" id="size-value">300px</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.corner_radius_label') }}</label>
                            <input type="range" id="corner-radius" class="range-input" min="0" max="20" value="0">
                            <div class="range-value" id="radius-value">0px</div>
                        </div>
                    </div>



                    <!-- Logo Upload -->
                    <div class="custom-group">
                        <h3>{{ __('app.logo_title') }}</h3>
                        <div id="logo-upload" class="logo-upload">
                            <div id="logo-content">
                                <div class="upload-text">{{ __('app.logo_upload_text') }}</div>
                                <div class="upload-hint">{{ __('app.logo_upload_hint') }}</div>
                            </div>
                            <input type="file" id="logo-file" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group" style="margin-top: 16px;">
                            <label class="form-label">{{ __('app.logo_size_label') }}</label>
                            <input type="range" id="logo-size" class="range-input" min="5" max="15" value="10">
                            <div class="range-value" id="logo-size-value">10%</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.logo_style_label') }}</label>
                            <select id="logo-style" class="form-input">
                                <option value="circular">{{ __('app.logo_style_circular') }}</option>
                                <option value="rounded">{{ __('app.logo_style_rounded') }}</option>
                                <option value="square">{{ __('app.logo_style_square') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Branding -->
                    <div class="custom-group">
                        <h3>{{ __('app.branding_title') }}</h3>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.brand_name_label') }}</label>
                            <input type="text" id="brand-name" class="form-input" placeholder="{{ __('app.brand_name_placeholder') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.description_label') }}</label>
                            <input type="text" id="description" class="form-input" placeholder="{{ __('app.description_placeholder') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('app.font_family_label') }}</label>
                            <select id="font-family" class="form-input">
                                <option value="SF Pro Display">{{ __('app.font_sf_pro') }}</option>
                                <option value="Arial">Arial</option>
                                <option value="Helvetica">Helvetica</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Trebuchet MS">Trebuchet MS</option>
                                <option value="Impact">Impact</option>
                                <option value="Comic Sans MS">Comic Sans MS</option>
                                <option value="Courier New">Courier New</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Open Sans">Open Sans</option>
                                <option value="Lato">Lato</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Poppins">Poppins</option>
                            </select>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="show-password-card" class="checkbox">
                            <label for="show-password-card" class="checkbox-label">{{ __('app.show_password_card_label') }}</label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Download Section -->
            <section id="download-section" class="download-section">
                <h2 class="panel-title">{{ __('app.download_title') }}</h2>
                <p class="qr-subtitle">{{ __('app.download_subtitle') }}</p>

                <div class="download-grid">
                    <button id="download-png" class="btn-download">{{ __('app.download_png') }}</button>
                    <button id="download-pdf" class="btn-download secondary">{{ __('app.download_pdf') }}</button>
                    <button id="download-card" class="btn-download">{{ __('app.download_card') }}</button>
                </div>
            </section>
        </main>

        <!-- SEO Content Section -->
        <section class="seo-content" style="background: #f5f5f7; padding: 80px 0; margin-top: 80px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 style="font-size: 32px; font-weight: 600; margin-bottom: 24px; color: #1d1d1f;">{{ __('app.why_use_title') }}</h2>
                        <div style="color: #86868b; font-size: 17px; line-height: 1.6;">
                            <p style="margin-bottom: 16px;">{{ __('app.why_use_description') }}</p>

                            <h3 style="font-size: 24px; font-weight: 600; margin: 32px 0 16px; color: #1d1d1f;">{{ __('app.key_features_title') }}</h3>
                            <ul style="margin-left: 20px; margin-bottom: 24px;">
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_free') }}</strong></li>
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_logos') }}</strong></li>
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_preview') }}</strong></li>
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_formats') }}</strong></li>
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_mobile') }}</strong></li>
                                <li style="margin-bottom: 8px;"><strong>{{ __('app.feature_secure') }}</strong></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 24px; color: #1d1d1f;">{{ __('app.perfect_for_title') }}</h3>
                        <div style="color: #86868b; font-size: 17px; line-height: 1.6;">
                            <div style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #f0f0f0;">
                                <h4 style="color: #1d1d1f; font-weight: 600; margin-bottom: 8px;">{{ __('app.perfect_restaurants') }}</h4>
                                <p style="margin: 0;">{{ __('app.perfect_restaurants_desc') }}</p>
                            </div>
                            <div style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #f0f0f0;">
                                <h4 style="color: #1d1d1f; font-weight: 600; margin-bottom: 8px;">{{ __('app.perfect_hotels') }}</h4>
                                <p style="margin: 0;">{{ __('app.perfect_hotels_desc') }}</p>
                            </div>
                            <div style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #f0f0f0;">
                                <h4 style="color: #1d1d1f; font-weight: 600; margin-bottom: 8px;">{{ __('app.perfect_offices') }}</h4>
                                <p style="margin: 0;">{{ __('app.perfect_offices_desc') }}</p>
                            </div>
                            <div style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #f0f0f0;">
                                <h4 style="color: #1d1d1f; font-weight: 600; margin-bottom: 8px;">{{ __('app.perfect_home') }}</h4>
                                <p style="margin: 0;">{{ __('app.perfect_home_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section" style="padding: 80px 0;">
            <div class="container">
                <h2 style="font-size: 32px; font-weight: 600; margin-bottom: 48px; color: #1d1d1f; text-align: center;">{{ __('app.faq_title') }}</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_how_work_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_how_work_a') }}</p>
                        </div>
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_secure_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_secure_a') }}</p>
                        </div>
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_customize_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_customize_a') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_devices_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_devices_a') }}</p>
                        </div>
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_free_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_free_a') }}</p>
                        </div>
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">{{ __('app.faq_formats_q') }}</h3>
                            <p style="color: #86868b; line-height: 1.6;">{{ __('app.faq_formats_a') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer style="background: #1d1d1f; color: #f5f5f7; padding: 48px 0; text-align: center;" role="contentinfo">
            <div class="container">
                <div style="margin-bottom: 24px;">
                    <img src="/images/logo-text.svg" alt="WiFi QR Generator" style="height: 40px; filter: invert(1);">
                </div>
                <p style="margin-bottom: 16px; font-size: 17px;">{{ __('app.footer_description') }}</p>
                <p style="color: #86868b; font-size: 15px; margin-bottom: 24px;">{{ __('app.footer_tagline') }}</p>
                <div style="border-top: 1px solid #424245; padding-top: 24px; margin-top: 24px;">
                    <p style="color: #86868b; font-size: 13px; margin: 0;">{{ __('app.footer_copyright') }}</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- QR Code Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.4/build/qrcode.min.js"></script>
    <script src="https://unpkg.com/qrcode@1.5.4/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Alternative QR library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>

    <script>
        // Global variables
        let currentQRData = '';
        let currentLogo = null;
        let qrCanvas = null;
        let updateTimeout = null;

        // DOM elements
        const wifiForm = document.getElementById('wifi-form');
        const qrSection = document.getElementById('qr-section');
        const customizationPanel = document.getElementById('customization-panel');
        const downloadSection = document.getElementById('download-section');
        const qrCodeContainer = document.getElementById('qr-code');

        // Form elements
        const ssidInput = document.getElementById('ssid');
        const passwordInput = document.getElementById('password');
        const noPasswordCheckbox = document.getElementById('no-password');

        // Customization elements
        const fgColorInput = document.getElementById('fg-color');
        const qrSizeInput = document.getElementById('qr-size');
        const cornerRadiusInput = document.getElementById('corner-radius');
        const logoUpload = document.getElementById('logo-upload');
        const logoFile = document.getElementById('logo-file');
        const logoSizeInput = document.getElementById('logo-size');
        const brandNameInput = document.getElementById('brand-name');
        const descriptionInput = document.getElementById('description');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for QRCode library to load
            checkQRCodeLibrary().then(() => {
                setupEventListeners();
            });
        });

        // Check if QRCode library is loaded
        function checkQRCodeLibrary() {
            return new Promise((resolve) => {
                // Wait a bit for libraries to load
                setTimeout(() => {
                    if (typeof QRCode !== 'undefined') {
                        resolve();
                    } else {
                        loadManualQRGenerator();
                        resolve();
                    }
                }, 1000);
            });
        }

        // Manual QR code generation fallback
        function loadManualQRGenerator() {
            // Show info message to user
            showInfoMessage('qrServiceInfo');

            window.QRCode = {
                toCanvas: function(canvas, text, options) {
                    return generateManualQR(canvas, text, options);
                },
                toString: function(text, options, callback) {
                    const size = options.width || 300;
                    const encodedText = encodeURIComponent(text);
                    const svg = `<svg width="${size}" height="${size}" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" fill="${options.color?.light || '#ffffff'}"/>
                        <text x="50%" y="30%" text-anchor="middle" font-family="monospace" font-size="12" fill="${options.color?.dark || '#000000'}">QR Code</text>
                        <text x="50%" y="50%" text-anchor="middle" font-family="monospace" font-size="8" fill="${options.color?.dark || '#000000'}">{{ __('app.card_scan_instruction') }}</text>
                        <text x="50%" y="70%" text-anchor="middle" font-family="monospace" font-size="6" fill="${options.color?.dark || '#000000'}">{{ __('app.card_wifi_network') }}</text>
                    </svg>`;
                    callback(null, svg);
                }
            };
        }

        function setupEventListeners() {
            // Form submission
            wifiForm.addEventListener('submit', handleFormSubmit);

            // Real-time WiFi input changes
            ssidInput.addEventListener('input', handleWiFiInputChange);
            passwordInput.addEventListener('input', handleWiFiInputChange);

            // Password toggle functionality
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = this.querySelector('.password-toggle-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.textContent = '🙈';
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.textContent = '👁️';
                }
            });

            // Password validation
            passwordInput.addEventListener('input', function() {
                if (!noPasswordCheckbox.checked) {
                    validatePassword(this.value);
                }
                handleWiFiInputChange();
            });

            passwordInput.addEventListener('focus', function() {
                if (!noPasswordCheckbox.checked) {
                    document.getElementById('password-requirements').style.display = 'block';
                }
            });

            passwordInput.addEventListener('blur', function() {
                setTimeout(() => {
                    document.getElementById('password-requirements').style.display = 'none';
                }, 200);
            });

            // No password checkbox
            noPasswordCheckbox.addEventListener('change', function() {
                const passwordContainer = document.querySelector('.password-input-container');
                const passwordRequirements = document.getElementById('password-requirements');

                passwordInput.disabled = this.checked;
                passwordInput.value = this.checked ? '' : passwordInput.value;
                passwordContainer.style.opacity = this.checked ? '0.5' : '1';
                passwordRequirements.style.display = 'none';

                if (this.checked) {
                    passwordInput.classList.remove('valid', 'invalid');
                }

                handleWiFiInputChange();
            });

            // Range inputs with real-time preview
            qrSizeInput.addEventListener('input', function() {
                document.getElementById('size-value').textContent = this.value + 'px';
                if (currentQRData) {
                    debounceUpdateQR();
                }
            });

            cornerRadiusInput.addEventListener('input', function() {
                document.getElementById('radius-value').textContent = this.value + 'px';
                if (currentQRData) {
                    debounceUpdateQR();
                }
            });

            logoSizeInput.addEventListener('input', function() {
                document.getElementById('logo-size-value').textContent = this.value + '%';
                if (currentQRData && currentLogo) debounceUpdateQR();
            });

            // Logo style selector
            document.getElementById('logo-style').addEventListener('change', function() {
                if (currentQRData && currentLogo) debounceUpdateQR();
            });

            // Color inputs with real-time preview
            fgColorInput.addEventListener('input', function() {
                if (currentQRData) debounceUpdateQR();
            });

            // Brand name and description inputs
            brandNameInput.addEventListener('input', function() {
                // These don't affect QR code directly
            });

            descriptionInput.addEventListener('input', function() {
                // These don't affect QR code directly
            });

            // Font family selector
            document.getElementById('font-family').addEventListener('change', function() {
                // Font changes only affect card downloads, not QR preview
            });

            // Logo upload
            logoUpload.addEventListener('click', () => logoFile.click());
            logoFile.addEventListener('change', handleLogoUpload);

            // Download buttons
            document.getElementById('download-png').addEventListener('click', () => {
                downloadQR('png');
            });
            document.getElementById('download-pdf').addEventListener('click', () => {
                downloadQR('pdf');
            });
            document.getElementById('download-card').addEventListener('click', () => {
                downloadCard();
            });
        }

        // Handle WiFi input changes for real-time QR generation
        function handleWiFiInputChange() {
            const ssid = ssidInput.value.trim();

            if (ssid) {
                const password = noPasswordCheckbox.checked ? '' : passwordInput.value;
                const encryption = noPasswordCheckbox.checked ? 'nopass' : 'WPA';

                // Validate password if not open network
                if (!noPasswordCheckbox.checked && password) {
                    const isPasswordValid = validatePassword(password);
                    // Password validation happens silently
                }

                // Create WiFi QR string
                currentQRData = `WIFI:T:${encryption};S:${ssid};P:${password};;`;

                // Update display info
                document.getElementById('display-ssid').textContent = ssid;
                document.getElementById('display-security').textContent = encryption === 'nopass' ? messages.securityOpen : messages.securityWpa;
                document.getElementById('wifi-info').style.display = 'block';

                // Generate QR with debounce
                debounceUpdateQR();
            } else {
                // Clear QR if no SSID
                currentQRData = '';
                qrCodeContainer.innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: #86868b; flex-direction: column;">
                        <div style="font-size: 48px; margin-bottom: 16px;">📱</div>
                        <div>${messages.qrPlaceholder}</div>
                    </div>
                `;
                document.getElementById('wifi-info').style.display = 'none';
            }
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            // Form submission now just triggers the same logic as real-time input
            handleWiFiInputChange();

            if (currentQRData) {
                showSuccessMessage('qrGenerated');
            }
        }

        // Debounced update function for smooth real-time updates
        function debounceUpdateQR() {
            if (updateTimeout) {
                clearTimeout(updateTimeout);
            }

            updateTimeout = setTimeout(() => {
                if (currentQRData) {
                    generateQRCode();
                }
            }, 300); // 300ms delay for smooth updates
        }

        function showErrorMessage(message) {
            showMessage(message, 'error-message', 5000);
        }

        function showSuccessMessage(message) {
            showMessage(message, 'success-message', 3000);
        }

        function showInfoMessage(message) {
            showMessage(message, 'info-message', 4000);
        }

        function showMessage(message, className, duration) {
            // Remove existing messages
            const existingMessages = document.querySelectorAll('.error-message, .success-message, .info-message');
            existingMessages.forEach(msg => msg.remove());

            // Create message
            const messageDiv = document.createElement('div');
            messageDiv.className = `${className} fade-in`;
            messageDiv.textContent = message;

            // Insert after form
            wifiForm.parentNode.insertBefore(messageDiv, wifiForm.nextSibling);

            // Auto remove after specified duration
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, duration);
        }



        async function generateQRCode() {
            if (!currentQRData) {
                showErrorMessage('No WiFi data to generate QR code');
                return;
            }

            try {
                // Always create a fresh canvas
                const canvas = document.createElement('canvas');
                const size = parseInt(qrSizeInput.value);

                // Check if QRCode library is available
                if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                    const options = {
                        width: size,
                        height: size,
                        margin: 4,
                        color: {
                            dark: fgColorInput.value,
                            light: '#ffffff'
                        },
                        errorCorrectionLevel: 'M'
                    };

                    await QRCode.toCanvas(canvas, currentQRData, options);
                } else {
                    // Use manual generator
                    canvas.width = size;
                    canvas.height = size;
                    await generateManualQR(canvas, currentQRData, {
                        width: size,
                        color: {
                            dark: fgColorInput.value,
                            light: '#ffffff'
                        }
                    });
                }

                // Apply corner radius if specified
                const radius = parseInt(cornerRadiusInput.value);
                if (radius > 0) {
                    applyCornerRadius(canvas, radius);
                }

                // Add logo if uploaded (with size limit)
                if (currentLogo) {
                    addLogoToCanvas(canvas);
                }

                qrCanvas = canvas;

                // Apply responsive styling to canvas for display
                const displaySize = Math.min(size, 350);
                canvas.style.width = displaySize + 'px';
                canvas.style.height = displaySize + 'px';
                canvas.style.maxWidth = '100%';
                canvas.style.display = 'block';
                canvas.style.margin = '0 auto';
                canvas.style.borderRadius = radius > 0 ? radius + 'px' : '0';

                // Clear container and add new QR
                qrCodeContainer.innerHTML = '';
                qrCodeContainer.appendChild(canvas);

                // Show download section only if QR was generated successfully
                if (!downloadSection.style.display || downloadSection.style.display === 'none') {
                    downloadSection.style.display = 'block';
                    downloadSection.classList.add('fade-in');
                }

            } catch (error) {
                console.error('Error in generateQRCode:', error);
                showErrorMessage('{{ __("app.js_error_generate_qr") }}' + error.message);
            }
        }

        // Manual QR generator using online service
        async function generateManualQR(canvas, text, options) {
            try {
                const size = options.width;
                const encodedText = encodeURIComponent(text);

                // Use QR Server API to generate actual QR code
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodedText}&format=PNG&bgcolor=${options.color.light.replace('#', '')}&color=${options.color.dark.replace('#', '')}`;

                const img = new Image();
                img.crossOrigin = 'anonymous';

                return new Promise((resolve, reject) => {
                    img.onload = function() {
                        const ctx = canvas.getContext('2d');
                        canvas.width = size;
                        canvas.height = size;

                        // Fill background first
                        ctx.fillStyle = options.color.light;
                        ctx.fillRect(0, 0, size, size);

                        // Draw the QR code image
                        ctx.drawImage(img, 0, 0, size, size);
                        resolve();
                    };

                    img.onerror = function() {
                        console.log('Online QR service failed, using local pattern');
                        generateLocalQRPattern(canvas, text, options);
                        resolve();
                    };

                    img.src = qrUrl;
                });

            } catch (error) {
                console.log('Manual QR generation failed, using local pattern');
                generateLocalQRPattern(canvas, text, options);
            }
        }

        // Local QR pattern as final fallback
        function generateLocalQRPattern(canvas, text, options) {
            const ctx = canvas.getContext('2d');
            const size = options.width;

            // Fill background
            ctx.fillStyle = options.color.light;
            ctx.fillRect(0, 0, size, size);

            ctx.fillStyle = options.color.dark;

            // Create a grid pattern that looks like QR
            const moduleSize = size / 25;

            // Draw finder patterns (corners)
            drawFinderPattern(ctx, 0, 0, moduleSize * 7);
            drawFinderPattern(ctx, size - moduleSize * 7, 0, moduleSize * 7);
            drawFinderPattern(ctx, 0, size - moduleSize * 7, moduleSize * 7);

            // Draw timing patterns
            for (let i = 8; i < 17; i++) {
                if (i % 2 === 0) {
                    ctx.fillRect(i * moduleSize, 6 * moduleSize, moduleSize, moduleSize);
                    ctx.fillRect(6 * moduleSize, i * moduleSize, moduleSize, moduleSize);
                }
            }

            // Draw data pattern based on text hash
            const hash = simpleHash(text);
            for (let i = 0; i < 25; i++) {
                for (let j = 0; j < 25; j++) {
                    if (!isReservedArea(i, j)) {
                        if ((hash + i * j) % 3 === 0) {
                            ctx.fillRect(i * moduleSize, j * moduleSize, moduleSize, moduleSize);
                        }
                    }
                }
            }

            function drawFinderPattern(ctx, x, y, size) {
                const moduleSize = size / 7;
                // Outer border
                ctx.fillRect(x, y, size, size);
                // Inner white
                ctx.fillStyle = options.color.light;
                ctx.fillRect(x + moduleSize, y + moduleSize, size - 2 * moduleSize, size - 2 * moduleSize);
                // Center black
                ctx.fillStyle = options.color.dark;
                ctx.fillRect(x + 2 * moduleSize, y + 2 * moduleSize, size - 4 * moduleSize, size - 4 * moduleSize);
            }

            function isReservedArea(i, j) {
                // Finder patterns
                if ((i < 9 && j < 9) || (i > 15 && j < 9) || (i < 9 && j > 15)) return true;
                // Timing patterns
                if ((i === 6 && j > 7 && j < 17) || (j === 6 && i > 7 && i < 17)) return true;
                return false;
            }

            function simpleHash(str) {
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = ((hash << 5) - hash + str.charCodeAt(i)) & 0xffffffff;
                }
                return Math.abs(hash);
            }
        }

        async function updateQRCode() {
            if (!currentQRData) return;

            try {
                await generateQRCode();
            } catch (error) {
                console.error('Failed to update QR code:', error);
                showErrorMessage('Failed to update QR code');
            }
        }

        function applyCornerRadius(canvas, radius) {
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            // Create new canvas with rounded corners
            const roundedCanvas = document.createElement('canvas');
            roundedCanvas.width = canvas.width;
            roundedCanvas.height = canvas.height;
            const roundedCtx = roundedCanvas.getContext('2d');

            // Create rounded rectangle path manually (for browser compatibility)
            roundedCtx.beginPath();
            drawRoundedRect(roundedCtx, 0, 0, canvas.width, canvas.height, radius);
            roundedCtx.clip();

            // Draw original image
            roundedCtx.putImageData(imageData, 0, 0);

            // Replace original canvas content
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(roundedCanvas, 0, 0);
        }

        function drawRoundedRect(ctx, x, y, width, height, radius) {
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
        }

        function addLogoToCanvas(canvas) {
            const logoStyle = document.getElementById('logo-style').value;
            addLogoToCanvasWithStyle(canvas, logoStyle);
        }

        function addLogoToCanvasWithStyle(canvas, logoStyle) {
            const ctx = canvas.getContext('2d');
            const logoSizePercent = parseInt(logoSizeInput.value) / 100;
            const logoSize = Math.min(canvas.width * logoSizePercent, canvas.width * 0.15); // Max 15% of canvas
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            // Save current state
            ctx.save();

            if (logoStyle === 'circular') {
                addCircularLogo(ctx, centerX, centerY, logoSize);
            } else if (logoStyle === 'rounded') {
                addRoundedSquareLogo(ctx, centerX, centerY, logoSize);
            } else {
                addSquareLogo(ctx, centerX, centerY, logoSize);
            }

            // Restore state
            ctx.restore();
        }

        function addCircularLogo(ctx, centerX, centerY, logoSize) {
            const backgroundRadius = logoSize * 0.7;
            const logoRadius = logoSize * 0.5;

            // Create circular background with gradient
            const gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, backgroundRadius);
            gradient.addColorStop(0, '#ffffff');
            gradient.addColorStop(1, adjustBrightness('#ffffff', -10));

            ctx.beginPath();
            ctx.arc(centerX, centerY, backgroundRadius, 0, 2 * Math.PI);
            ctx.fillStyle = gradient;
            ctx.fill();

            // Add shadow
            ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
            ctx.shadowBlur = 6;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fill();

            // Reset shadow
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;

            // Add elegant border
            ctx.beginPath();
            ctx.arc(centerX, centerY, backgroundRadius, 0, 2 * Math.PI);
            ctx.strokeStyle = fgColorInput.value;
            ctx.lineWidth = 2;
            ctx.stroke();

            // Create circular clipping path for logo
            ctx.beginPath();
            ctx.arc(centerX, centerY, logoRadius, 0, 2 * Math.PI);
            ctx.clip();

            // Draw logo
            const logoX = centerX - logoRadius;
            const logoY = centerY - logoRadius;
            ctx.drawImage(currentLogo, logoX, logoY, logoRadius * 2, logoRadius * 2);
        }

        function addRoundedSquareLogo(ctx, centerX, centerY, logoSize) {
            const backgroundSize = logoSize * 0.9;
            const logoSizeActual = logoSize * 0.7;
            const cornerRadius = backgroundSize * 0.2;

            // Create rounded square background
            const x = centerX - backgroundSize / 2;
            const y = centerY - backgroundSize / 2;

            // Background with gradient
            const gradient = ctx.createLinearGradient(x, y, x + backgroundSize, y + backgroundSize);
            gradient.addColorStop(0, '#ffffff');
            gradient.addColorStop(1, adjustBrightness('#ffffff', -15));

            ctx.fillStyle = gradient;
            drawRoundedRect(ctx, x, y, backgroundSize, backgroundSize, cornerRadius);
            ctx.fill();

            // Add shadow
            ctx.shadowColor = 'rgba(0, 0, 0, 0.25)';
            ctx.shadowBlur = 8;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fill();

            // Reset shadow
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;

            // Add border
            ctx.strokeStyle = fgColorInput.value;
            ctx.lineWidth = 2;
            ctx.stroke();

            // Clip logo to rounded square
            drawRoundedRect(ctx, x + 4, y + 4, backgroundSize - 8, backgroundSize - 8, cornerRadius - 2);
            ctx.clip();

            // Draw logo
            const logoX = centerX - logoSizeActual / 2;
            const logoY = centerY - logoSizeActual / 2;
            ctx.drawImage(currentLogo, logoX, logoY, logoSizeActual, logoSizeActual);
        }

        function addSquareLogo(ctx, centerX, centerY, logoSize) {
            const backgroundSize = logoSize * 0.9;
            const logoSizeActual = logoSize * 0.8;
            const padding = backgroundSize * 0.1;

            // Create square background
            const x = centerX - backgroundSize / 2;
            const y = centerY - backgroundSize / 2;

            // Background
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(x, y, backgroundSize, backgroundSize);

            // Add shadow
            ctx.shadowColor = 'rgba(0, 0, 0, 0.2)';
            ctx.shadowBlur = 6;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fillRect(x, y, backgroundSize, backgroundSize);

            // Reset shadow
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;

            // Add border
            ctx.strokeStyle = fgColorInput.value;
            ctx.lineWidth = 2;
            ctx.strokeRect(x, y, backgroundSize, backgroundSize);

            // Draw logo
            const logoX = centerX - logoSizeActual / 2;
            const logoY = centerY - logoSizeActual / 2;
            ctx.drawImage(currentLogo, logoX, logoY, logoSizeActual, logoSizeActual);
        }

        // Helper function to adjust color brightness
        function adjustBrightness(color, amount) {
            const usePound = color[0] === '#';
            const col = usePound ? color.slice(1) : color;
            const num = parseInt(col, 16);
            let r = (num >> 16) + amount;
            let g = (num >> 8 & 0x00FF) + amount;
            let b = (num & 0x0000FF) + amount;
            r = r > 255 ? 255 : r < 0 ? 0 : r;
            g = g > 255 ? 255 : g < 0 ? 0 : g;
            b = b > 255 ? 255 : b < 0 ? 0 : b;
            return (usePound ? '#' : '') + (r << 16 | g << 8 | b).toString(16).padStart(6, '0');
        }

        // Helper function to wrap text for canvas
        function wrapText(ctx, text, maxWidth) {
            const words = text.split(' ');
            const lines = [];
            let currentLine = words[0];

            for (let i = 1; i < words.length; i++) {
                const word = words[i];
                const width = ctx.measureText(currentLine + ' ' + word).width;

                if (width < maxWidth) {
                    currentLine += ' ' + word;
                } else {
                    lines.push(currentLine);
                    currentLine = word;
                }
            }

            lines.push(currentLine);
            return lines;
        }

        // Password validation function
        function validatePassword(password) {
            const lengthCheck = document.getElementById('length-check');
            const charCheck = document.getElementById('char-check');
            const passwordInput = document.getElementById('password');

            // Check length (minimum 8 characters for WPA/WPA2)
            const isLengthValid = password.length >= 8;
            lengthCheck.className = `requirement ${isLengthValid ? 'valid' : 'invalid'}`;
            lengthCheck.textContent = isLengthValid ? '{{ __("app.js_length_valid") }}' : '{{ __("app.js_length_invalid") }}';

            // Check valid WiFi password characters
            // WiFi passwords can contain most printable ASCII characters
            // Avoid problematic characters: quotes, backslashes, some special chars
            const validCharsRegex = /^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{}|;:,.<>?~`\s]*$/;
            const isCharsValid = validCharsRegex.test(password);
            charCheck.className = `requirement ${isCharsValid ? 'valid' : 'invalid'}`;
            charCheck.textContent = isCharsValid ? '{{ __("app.js_chars_valid") }}' : '{{ __("app.js_chars_invalid") }}';

            // Overall validation
            const isValid = isLengthValid && isCharsValid && password.length > 0;

            if (password.length === 0) {
                passwordInput.classList.remove('valid', 'invalid');
            } else if (isValid) {
                passwordInput.classList.remove('invalid');
                passwordInput.classList.add('valid');
            } else {
                passwordInput.classList.remove('valid');
                passwordInput.classList.add('invalid');
            }

            return isValid;
        }

        function handleLogoUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                showErrorMessage('File size must be less than 2MB');
                return;
            }

            if (!file.type.startsWith('image/')) {
                showErrorMessage('Please select a valid image file (PNG, JPG, GIF)');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    currentLogo = img;

                    // Update upload area
                    const logoContent = document.getElementById('logo-content');
                    logoContent.innerHTML = `
                        <img src="${e.target.result}" class="logo-preview" alt="Logo preview">
                        <div class="upload-text">{{ __("app.js_logo_uploaded") }}</div>
                        <div class="upload-hint">{{ __("app.js_click_to_change") }}</div>
                    `;
                    logoUpload.classList.add('has-logo');

                    // Update QR if it exists
                    if (currentQRData) {
                        debounceUpdateQR();
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Generate high-quality QR for download
        async function generateHighQualityQR(targetSize = null) {
            const downloadSize = targetSize || parseInt(qrSizeInput.value);
            const canvas = document.createElement('canvas');

            try {
                // Generate QR with current settings but at specified size
                if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                    const options = {
                        width: downloadSize,
                        height: downloadSize,
                        margin: 4,
                        color: {
                            dark: fgColorInput.value,
                            light: '#ffffff'
                        },
                        errorCorrectionLevel: 'M'
                    };

                    await QRCode.toCanvas(canvas, currentQRData, options);
                } else {
                    canvas.width = downloadSize;
                    canvas.height = downloadSize;
                    await generateManualQR(canvas, currentQRData, {
                        width: downloadSize,
                        color: {
                            dark: fgColorInput.value,
                            light: '#ffffff'
                        }
                    });
                }

                // Apply corner radius if specified
                const radius = parseInt(cornerRadiusInput.value);
                if (radius > 0) {
                    // Scale radius proportionally for different download sizes
                    const currentPreviewSize = parseInt(qrSizeInput.value);
                    const scaledRadius = Math.round(radius * (downloadSize / currentPreviewSize));
                    applyCornerRadius(canvas, scaledRadius);
                }

                // Add logo if uploaded
                if (currentLogo) {
                    const logoStyle = document.getElementById('logo-style').value;
                    addLogoToCanvasWithStyle(canvas, logoStyle);
                }

                return canvas;

            } catch (error) {
                console.error('Error generating high-quality QR:', error);
                return qrCanvas; // Fallback to current canvas
            }
        }

        function downloadQR(format) {
            if (!qrCanvas) {
                showErrorMessage('{{ __("app.js_generate_qr_first") }}');
                return;
            }

            try {
                const ssid = ssidInput.value.trim() || 'wifi';
                const filename = `wifi-qr-${ssid}`;

                // Track download before starting (don't await to not block download)
                trackDownload(format, ssid).catch(err => {
                    // Tracking failed silently
                });

                if (format === 'png') {
                    // Generate high-quality version for download
                    generateHighQualityQR(512).then(highQualityCanvas => {
                        try {
                            const link = document.createElement('a');
                            link.download = `${filename}.png`;
                            link.href = highQualityCanvas.toDataURL('image/png');
                            link.click();
                            showSuccessMessage('pngDownloaded');
                        } catch (error) {
                            showErrorMessage('Failed to download PNG. Please try again.');
                        }
                    }).catch(error => {
                        showErrorMessage('Failed to generate QR code.');
                    });
                } else if (format === 'pdf') {
                    // Generate high-quality version for PDF
                    generateHighQualityQR(400).then(highQualityCanvas => {
                        try {
                            const { jsPDF } = window.jspdf;
                            const pdf = new jsPDF();

                            const imgData = highQualityCanvas.toDataURL('image/png');
                            const size = parseInt(qrSizeInput.value);

                            // Scale for PDF (convert px to mm, 1px ≈ 0.264583mm)
                            const pdfSize = Math.min(size * 0.264583, 150); // Max 150mm
                            const x = (pdf.internal.pageSize.getWidth() - pdfSize) / 2;
                            const y = 50;

                            pdf.addImage(imgData, 'PNG', x, y, pdfSize, pdfSize);
                            pdf.save(`${filename}.pdf`);
                            showSuccessMessage('pdfDownloaded');
                        } catch (error) {
                            showErrorMessage('Failed to download PDF. Please try again.');
                        }
                    }).catch(error => {
                        showErrorMessage('Failed to generate QR code.');
                    });
                }

            } catch (error) {
                console.error('Download error:', error);
                showErrorMessage(`Failed to download ${format.toUpperCase()}. Please try again.`);
            }
        }

        // Track download function
        async function trackDownload(type, ssid) {
            try {
                // Safe variable access with fallbacks
                let hasLogo = false;
                let hasCustomColors = false;

                try {
                    // Check the actual file input, not the container div
                    const logoFileInput = document.getElementById('logo-file');
                    hasLogo = logoFileInput && logoFileInput.files && logoFileInput.files.length > 0;
                } catch (e) {
                    // Silent fallback
                }

                try {
                    hasCustomColors = fgColorInput && fgColorInput.value !== '#000000';
                } catch (e) {
                    // Silent fallback
                }

                const response = await fetch('/api/track-download', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                        // Removed CSRF token since it's excluded in middleware
                    },
                    body: JSON.stringify({
                        type: type,
                        ssid: ssid,
                        has_logo: hasLogo,
                        has_custom_colors: hasCustomColors
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();
                // Tracking completed silently

            } catch (error) {
                // Tracking failed silently, don't interrupt user experience
            }
        }

        // Function to load fonts before generating card
        async function loadFont(fontFamily) {
            try {
                // Check if font is available
                if (document.fonts && document.fonts.load) {
                    await document.fonts.load(`16px "${fontFamily}"`);
                    return true;
                }
            } catch (error) {
                // Font loading failed silently
            }
            return false;
        }

        async function downloadCard() {
            if (!qrCanvas) {
                showErrorMessage('Please generate a QR code first');
                return;
            }

            // Track download before starting (don't await to not block download)
            const ssid = ssidInput.value.trim() || 'wifi';
            trackDownload('card', ssid).catch(err => {
                // Tracking failed silently
            });

            // Get selected font and try to load it
            const fontSelector = document.getElementById('font-family');
            const selectedFont = fontSelector ? fontSelector.value : 'SF Pro Display';

            // Try to load the font first
            await loadFont(selectedFont);

            // Generate high-quality QR for card
            generateHighQualityQR(300).then(highQualityQR => {
                try {
                // Create vertical card canvas
                const cardCanvas = document.createElement('canvas');
                cardCanvas.width = 400;
                cardCanvas.height = 600;
                const ctx = cardCanvas.getContext('2d');

                // Card background
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, cardCanvas.width, cardCanvas.height);

                // Add subtle border
                ctx.strokeStyle = '#e5e5e7';
                ctx.lineWidth = 1;
                ctx.strokeRect(0, 0, cardCanvas.width, cardCanvas.height);

                let currentY = 40; // Start higher to save space
                const availableHeight = cardCanvas.height - 80; // Reserve space for bottom content

                // Get selected font family (already loaded above)

                // Add brand name at top if provided (with adaptive font size)
                const brandName = brandNameInput.value.trim();
                if (brandName) {
                    ctx.fillStyle = '#1d1d1f';
                    ctx.textAlign = 'center';

                    // Adaptive font size based on text length
                    let fontSize = brandName.length > 30 ? 20 : brandName.length > 20 ? 24 : 28;

                    // Try multiple font formats for better compatibility
                    const fontFormats = [
                        `bold ${fontSize}px "${selectedFont}", Arial, sans-serif`,
                        `bold ${fontSize}px ${selectedFont}, Arial, sans-serif`,
                        `bold ${fontSize}px Arial, sans-serif`
                    ];

                    let fontApplied = false;
                    for (const fontString of fontFormats) {
                        ctx.font = fontString;
                        // Test if font was actually applied by measuring text
                        const testWidth = ctx.measureText('Test').width;
                        if (testWidth > 0) {
                            fontApplied = true;
                            break;
                        }
                    }

                    // Wrap brand name if too long
                    const maxWidth = cardCanvas.width - 40;
                    const lines = wrapText(ctx, brandName, maxWidth);

                    // Limit to 2 lines for brand name
                    const displayLines = lines.slice(0, 2);
                    const lineHeight = fontSize + 7;

                    displayLines.forEach((line, index) => {
                        ctx.fillText(line, cardCanvas.width / 2, currentY + (index * lineHeight));
                    });

                    currentY += (displayLines.length * lineHeight) + 10;
                }

                // Add description if provided (with adaptive font size and height limit)
                const description = descriptionInput.value.trim();
                if (description) {
                    ctx.fillStyle = '#86868b';
                    ctx.textAlign = 'center';

                    // Adaptive font size based on text length
                    let fontSize = description.length > 150 ? 14 : description.length > 100 ? 16 : 18;

                    // Apply font with fallbacks
                    const fontFormats = [
                        `${fontSize}px "${selectedFont}", Arial, sans-serif`,
                        `${fontSize}px ${selectedFont}, Arial, sans-serif`,
                        `${fontSize}px Arial, sans-serif`
                    ];

                    for (const fontString of fontFormats) {
                        ctx.font = fontString;
                        if (ctx.measureText('Test').width > 0) break;
                    }

                    // Wrap text if too long
                    const maxWidth = cardCanvas.width - 60;
                    const lines = wrapText(ctx, description, maxWidth);

                    // Limit to 4 lines maximum to prevent layout issues
                    const maxLines = 4;
                    const displayLines = lines.slice(0, maxLines);
                    const lineHeight = fontSize + 5;

                    // Calculate max height for description area
                    const maxDescriptionHeight = 100; // Reserve space for QR and other content
                    const actualHeight = displayLines.length * lineHeight;

                    if (actualHeight <= maxDescriptionHeight) {
                        displayLines.forEach((line, index) => {
                            ctx.fillText(line, cardCanvas.width / 2, currentY + (index * lineHeight));
                        });
                        currentY += actualHeight + 10;
                    } else {
                        // If still too long, truncate and add ellipsis
                        const truncatedLines = displayLines.slice(0, 3);
                        truncatedLines.forEach((line, index) => {
                            if (index === 2) {
                                // Add ellipsis to last line
                                line = line.substring(0, line.length - 3) + '...';
                            }
                            ctx.fillText(line, cardCanvas.width / 2, currentY + (index * lineHeight));
                        });
                        currentY += (3 * lineHeight) + 10;
                    }
                }

                // Calculate remaining space for QR and bottom content
                const remainingHeight = cardCanvas.height - currentY - 120; // Reserve 120px for bottom content
                const qrSize = Math.min(250, remainingHeight - 40); // Adaptive QR size
                const qrX = (cardCanvas.width - qrSize) / 2;
                const qrY = currentY + 15;

                // Apply corner radius to QR in card if specified
                const radius = parseInt(cornerRadiusInput.value);
                if (radius > 0) {
                    // Create a clipping path with rounded corners
                    ctx.save();
                    ctx.beginPath();
                    drawRoundedRect(ctx, qrX, qrY, qrSize, qrSize, radius);
                    ctx.clip();

                    // Draw the QR canvas
                    ctx.drawImage(highQualityQR, qrX, qrY, qrSize, qrSize);
                    ctx.restore();
                } else {
                    // Draw normally without corner radius
                    ctx.drawImage(highQualityQR, qrX, qrY, qrSize, qrSize);
                }

                currentY = qrY + qrSize + 25;

                // Ensure we have enough space for bottom content
                const remainingSpace = cardCanvas.height - currentY - 20; // 20px bottom margin

                // Add WiFi network name (with adaptive font size)
                ctx.fillStyle = '#1d1d1f';
                ctx.textAlign = 'center';

                // Adaptive font size for network name
                const networkName = ssidInput.value;
                let networkFontSize = networkName.length > 25 ? 18 : networkName.length > 15 ? 20 : 22;

                // Apply font with fallbacks
                const networkFontFormats = [
                    `bold ${networkFontSize}px "${selectedFont}", Arial, sans-serif`,
                    `bold ${networkFontSize}px ${selectedFont}, Arial, sans-serif`,
                    `bold ${networkFontSize}px Arial, sans-serif`
                ];

                for (const fontString of networkFontFormats) {
                    ctx.font = fontString;
                    if (ctx.measureText('Test').width > 0) break;
                }

                // Wrap network name if too long (max 2 lines)
                const maxWidth = cardCanvas.width - 40;
                const networkLines = wrapText(ctx, networkName, maxWidth).slice(0, 2);
                const networkLineHeight = networkFontSize + 5;

                networkLines.forEach((line, index) => {
                    ctx.fillText(line, cardCanvas.width / 2, currentY + (index * networkLineHeight));
                });

                currentY += (networkLines.length * networkLineHeight) + 15;

                // Add password if checkbox is checked and password exists (only if space available)
                const showPassword = document.getElementById('show-password-card');
                if (showPassword && showPassword.checked && !noPasswordCheckbox.checked && passwordInput.value) {
                    const passwordSpace = cardCanvas.height - currentY - 10;
                    if (passwordSpace > 25) { // Only show if enough space
                        ctx.fillStyle = '#86868b';

                        // Apply font with fallbacks
                        const passwordFontFormats = [
                            `16px "${selectedFont}", Arial, sans-serif`,
                            `16px ${selectedFont}, Arial, sans-serif`,
                            `16px Arial, sans-serif`
                        ];

                        for (const fontString of passwordFontFormats) {
                            ctx.font = fontString;
                            if (ctx.measureText('Test').width > 0) break;
                        }

                        // Truncate password if too long
                        let passwordText = `{{ __('app.card_password_label') }} ${passwordInput.value}`;
                        const maxPasswordWidth = cardCanvas.width - 40;
                        while (ctx.measureText(passwordText).width > maxPasswordWidth && passwordText.length > 15) {
                            passwordText = passwordText.substring(0, passwordText.length - 4) + '...';
                        }

                        ctx.fillText(passwordText, cardCanvas.width / 2, currentY);
                    }
                }

                // Download card
                const link = document.createElement('a');
                const ssid = ssidInput.value.trim() || 'wifi';
                link.download = `wifi-card-${ssid}.png`;
                link.href = cardCanvas.toDataURL();
                link.click();

                showSuccessMessage('cardDownloaded');

                } catch (error) {
                    showErrorMessage('Failed to download WiFi card. Please try again.');
                }
            }).catch(error => {
                showErrorMessage('Failed to generate high-quality QR for card.');
            });
        }

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

        // Localized messages
        const messages = {
            qrGenerated: '{{ __("app.qr_generated_success") }}',
            pngDownloaded: '{{ __("app.png_downloaded_success") }}',
            pdfDownloaded: '{{ __("app.pdf_downloaded_success") }}',
            cardDownloaded: '{{ __("app.card_downloaded_success") }}',
            passwordWeak: '{{ __("app.password_weak_warning") }}',
            qrServiceInfo: '{{ __("app.qr_service_info") }}',
            securityOpen: '{{ __("app.security_open") }}',
            securityWpa: '{{ __("app.security_wpa") }}',
            qrPlaceholder: '{{ __("app.qr_placeholder") }}'
        };

        // Update showSuccessMessage to use localized messages
        function showSuccessMessage(messageKey) {
            const message = messages[messageKey] || messageKey;
            const messageDiv = document.createElement('div');
            messageDiv.className = 'success-message';
            messageDiv.textContent = message;

            const container = document.querySelector('.container');
            container.insertBefore(messageDiv, container.firstChild);

            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // Update showInfoMessage to use localized messages
        function showInfoMessage(messageKey) {
            const message = messages[messageKey] || messageKey;
            const messageDiv = document.createElement('div');
            messageDiv.className = 'info-message';
            messageDiv.textContent = message;

            const container = document.querySelector('.container');
            container.insertBefore(messageDiv, container.firstChild);

            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // Statistics Counter Animation
        class StatsCounter {
            constructor() {
                this.counter = document.getElementById('stats-counter');
                this.currentValue = parseInt(this.counter.dataset.target) || 1000000;
                this.displayValue = this.currentValue;
                this.targetValue = this.currentValue;
                this.isAnimating = false;
                this.lastUpdateTime = Date.now();
                this.pendingUpdates = [];
                this.lastServerValue = this.currentValue;

                this.init();
            }

            init() {
                // Fetch initial server value immediately
                this.fetchLatestStats();

                // Update display immediately
                this.updateDisplay(this.currentValue, false);

                // Fetch latest stats every 5 seconds (more frequent)
                setInterval(() => {
                    this.fetchLatestStats();
                }, 5000);

                // Process pending updates every 2-4 seconds
                this.startUpdateProcessor();
            }

            animateToTarget() {
                if (this.isAnimating || this.displayValue === this.targetValue) return;

                this.isAnimating = true;
                const startValue = this.displayValue;
                const endValue = this.targetValue;
                const duration = 1500; // Reduced to 1.5 seconds
                const startTime = Date.now();

                const animate = () => {
                    const elapsed = Date.now() - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Smoother easing function
                    const easeOutCubic = 1 - Math.pow(1 - progress, 3);

                    const currentValue = Math.floor(startValue + (endValue - startValue) * easeOutCubic);
                    this.updateDisplay(currentValue, false);

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        this.displayValue = endValue;
                        this.isAnimating = false;

                        // Process next pending update if any
                        this.processNextUpdate();
                    }
                };

                requestAnimationFrame(animate);
            }

            updateDisplay(value, animate = true) {
                this.counter.textContent = this.formatNumber(value);
                this.displayValue = value;

                // Only add animation class occasionally to reduce flicker
                if (animate && Math.random() < 0.3) {
                    this.counter.classList.add('stats-counter-animate');
                    setTimeout(() => {
                        this.counter.classList.remove('stats-counter-animate');
                    }, 300);
                }
            }

            formatNumber(num) {
                return new Intl.NumberFormat().format(num);
            }

            async fetchLatestStats() {
                try {
                    const response = await fetch('/api/stats');
                    const data = await response.json();

                    // Always update to server value to ensure consistency
                    if (data.count !== this.lastServerValue) {
                        this.lastServerValue = data.count;
                        this.currentValue = data.count;
                        this.queueUpdate(data.count);

                        // Add visual feedback that update happened
                        this.showUpdateIndicator();
                    }
                } catch (error) {
                    console.log('Stats update failed:', error);
                }
            }

            showUpdateIndicator() {
                // Briefly flash the pulse indicator
                const indicator = document.querySelector('.stats-section .pulse-indicator');
                if (indicator) {
                    indicator.style.animation = 'none';
                    setTimeout(() => {
                        indicator.style.animation = 'pulse 2s infinite';
                    }, 10);
                }
            }

            queueUpdate(newValue) {
                // Add to pending updates queue
                this.pendingUpdates.push(newValue);
            }

            processNextUpdate() {
                if (this.pendingUpdates.length > 0 && !this.isAnimating) {
                    // Take the latest value from queue
                    this.targetValue = this.pendingUpdates.pop();
                    this.pendingUpdates = []; // Clear queue to avoid backlog
                    this.animateToTarget();
                }
            }

            startUpdateProcessor() {
                const process = () => {
                    // Fetch fresh data from server instead of local increment
                    // This ensures all language versions show the same number
                    this.fetchLatestStats();

                    // Process any pending updates
                    this.processNextUpdate();

                    // Schedule next update in 2-4 seconds (shorter intervals)
                    const nextUpdate = Math.random() * 2000 + 2000;
                    setTimeout(process, nextUpdate);
                };

                // Start first update after 2 seconds
                setTimeout(process, 2000);
            }
        }

        // Initialize stats counter when page loads
        document.addEventListener('DOMContentLoaded', function() {
            new StatsCounter();
        });

        // Increment stats when QR is generated
        function incrementQrStats() {
            fetch('/api/stats/increment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            }).catch(error => {
                console.log('Stats increment failed:', error);
            });
        }

        // QR generation stats are now handled by download tracking
    </script>
</body>
</html>
