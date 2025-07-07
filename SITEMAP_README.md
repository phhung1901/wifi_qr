# Sitemap Management for WiFi QR Generator

## Overview
This project includes a comprehensive sitemap system to help Google and other search engines properly index your WiFi QR Generator website while preventing indexing of admin and sensitive areas.

## Files Created/Updated

### 1. Sitemap Files
- `public/sitemap.xml` - Main sitemap with all public pages
- `public/sitemap-images.xml` - Image sitemap for SEO
- `public/sitemap-index.xml` - Sitemap index file that references all sitemaps

### 2. Robots.txt Protection
- `public/robots.txt` - Updated with admin protection rules:
  ```
  Disallow: /admin/
  Disallow: /admin/*
  Disallow: /api/
  Disallow: /api/*
  ```

### 3. Laravel Components
- `app/Console/Commands/GenerateSitemap.php` - Command to generate sitemaps
- `app/Http/Middleware/NoIndexAdminPages.php` - Middleware to add noindex headers to admin pages
- `app/Console/Kernel.php` - Scheduled task to update sitemaps daily
- `routes/web.php` - Routes to serve sitemap files with proper headers

## Admin Page Protection

### Multiple Layers of Protection:
1. **robots.txt** - Tells search engines not to crawl admin pages
2. **Sitemap exclusion** - Admin pages are not included in any sitemap
3. **Meta robots middleware** - Adds `noindex, nofollow` headers to admin pages
4. **HTTP headers** - Adds `X-Robots-Tag` header for additional protection

## Usage

### Manual Sitemap Generation
```bash
php artisan sitemap:generate --domain=http://wifiqr.net
```

### Automatic Updates
Sitemaps are automatically regenerated daily at 2:00 AM (Ho Chi Minh timezone) via Laravel's task scheduler.

To enable the scheduler, add this to your crontab:
```bash
* * * * * cd /var/www/phamhung/wifi_qr && php artisan schedule:run >> /dev/null 2>&1
```

### Accessing Sitemaps
- Main sitemap: `http://wifiqr.net/sitemap.xml`
- Image sitemap: `http://wifiqr.net/sitemap-images.xml`
- Sitemap index: `http://wifiqr.net/sitemap-index.xml`

## Google Search Console Setup

1. Go to [Google Search Console](https://search.google.com/search-console/)
2. Add your property (wifiqr.net)
3. Submit your sitemap index: `http://wifiqr.net/sitemap-index.xml`

## Customization

### Adding New Pages
Edit `app/Console/Commands/GenerateSitemap.php` and add new routes to the `getPublicRoutes()` method:

```php
['url' => '/new-page', 'priority' => '0.8', 'changefreq' => 'weekly'],
```

### Adding New Images
Edit the `getImageUrls()` method in the same file:

```php
'/new-page' => [
    ['url' => '/images/new-image.jpg', 'title' => 'Image Title', 'caption' => 'Image Description'],
],
```

### Changing Domain
Update the domain in:
1. `app/Console/Kernel.php` (scheduled task)
2. `public/robots.txt` (sitemap URLs and host directive)
3. Run: `php artisan sitemap:generate --domain=http://your-new-domain.com`

## Verification

### Check robots.txt
Visit: `http://wifiqr.net/robots.txt`

### Test Admin Protection
1. Visit any admin page: `http://wifiqr.net/admin/dashboard`
2. Check page source for: `<meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex">`
3. Check response headers for: `X-Robots-Tag: noindex, nofollow, noarchive, nosnippet, noimageindex`

### Validate Sitemaps
Use Google's [Sitemap Validator](https://www.xml-sitemaps.com/validate-xml-sitemap.html) or similar tools.

## Maintenance

- Sitemaps update automatically daily
- Add new pages to the sitemap generator when creating new routes
- Monitor Google Search Console for crawl errors
- Update robots.txt if you add new sensitive directories

## Security Notes

- Admin pages are protected from indexing but still require proper authentication
- The middleware adds multiple layers of protection against search engine indexing
- API endpoints are also excluded from indexing for security
