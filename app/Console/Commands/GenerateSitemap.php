<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--domain=http://wifiqr.net}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemaps for Google Search Console';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $domain = $this->option('domain');
        $currentDate = Carbon::now()->format('Y-m-d');
        
        $this->info('Generating sitemaps...');
        
        // Generate main sitemap
        $this->generateMainSitemap($domain, $currentDate);
        
        // Generate image sitemap
        $this->generateImageSitemap($domain, $currentDate);
        
        // Generate sitemap index
        $this->generateSitemapIndex($domain, $currentDate);
        
        $this->info('Sitemaps generated successfully!');
        
        return 0;
    }

    private function generateMainSitemap($domain, $currentDate)
    {
        $routes = $this->getPublicRoutes();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        
        foreach ($routes as $route) {
            $xml .= $this->generateUrlEntry($domain, $route, $currentDate);
        }
        
        $xml .= '</urlset>' . "\n";
        
        file_put_contents(public_path('sitemap.xml'), $xml);
        $this->info('Main sitemap generated: sitemap.xml');
    }

    private function generateImageSitemap($domain, $currentDate)
    {
        $images = $this->getImageUrls();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        
        foreach ($images as $pageUrl => $pageImages) {
            $xml .= "    <url>\n";
            $xml .= "        <loc>{$domain}{$pageUrl}</loc>\n";
            
            foreach ($pageImages as $image) {
                $xml .= "        <image:image>\n";
                $xml .= "            <image:loc>{$domain}{$image['url']}</image:loc>\n";
                $xml .= "            <image:title>{$image['title']}</image:title>\n";
                $xml .= "            <image:caption>{$image['caption']}</image:caption>\n";
                $xml .= "        </image:image>\n";
            }
            
            $xml .= "    </url>\n";
        }
        
        $xml .= '</urlset>' . "\n";
        
        file_put_contents(public_path('sitemap-images.xml'), $xml);
        $this->info('Image sitemap generated: sitemap-images.xml');
    }

    private function generateSitemapIndex($domain, $currentDate)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $sitemaps = [
            'sitemap.xml' => $currentDate,
            'sitemap-images.xml' => $currentDate,
        ];
        
        foreach ($sitemaps as $sitemap => $lastmod) {
            $xml .= "    <sitemap>\n";
            $xml .= "        <loc>{$domain}/{$sitemap}</loc>\n";
            $xml .= "        <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    </sitemap>\n";
        }
        
        $xml .= '</sitemapindex>' . "\n";
        
        file_put_contents(public_path('sitemap-index.xml'), $xml);
        $this->info('Sitemap index generated: sitemap-index.xml');
    }

    private function getPublicRoutes()
    {
        $routes = [
            // Main pages
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/wifi-qr', 'priority' => '0.9', 'changefreq' => 'daily'],
            
            // High-value keyword pages
            ['url' => '/free-wifi-qr-code-generator', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/qr-code-for-wifi', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/wifi-qr-generator', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/custom-wifi-qr-code', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/wifi-qr-code-with-logo', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/wifi-password-qr-code', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/wifi-qr-code-maker', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/generate-wifi-qr-code', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/instant-wifi-connection', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/business-wifi-qr-code', 'priority' => '0.7', 'changefreq' => 'weekly'],
            
            // Industry-specific pages
            ['url' => '/restaurant-wifi-qr', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/hotel-wifi-qr', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/office-wifi-qr', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/cafe-wifi-qr-code', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/event-wifi-qr-code', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/retail-wifi-qr-code', 'priority' => '0.7', 'changefreq' => 'weekly'],
            
            // Content pages
            ['url' => '/blog', 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['url' => '/guide', 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['url' => '/how-to-create-wifi-qr-code', 'priority' => '0.6', 'changefreq' => 'weekly'],
        ];
        
        // Add multilingual routes
        $languages = ['es', 'fr', 'de', 'zh', 'ja', 'ko', 'vi', 'hi', 'id'];
        foreach ($languages as $lang) {
            $routes[] = ['url' => "/{$lang}/", 'priority' => '0.9', 'changefreq' => 'daily'];
        }
        
        return $routes;
    }

    private function getImageUrls()
    {
        return [
            '/' => [
                ['url' => '/images/og-image.svg', 'title' => 'Free WiFi QR Code Generator', 'caption' => 'Generate beautiful, customizable WiFi QR codes'],
                ['url' => '/images/logo.svg', 'title' => 'WiFi QR Generator Logo', 'caption' => 'Official logo of WiFi QR Generator'],
                ['url' => '/favicon.ico', 'title' => 'WiFi QR Generator Favicon', 'caption' => 'Website favicon'],
            ],
            '/restaurant-wifi-qr' => [
                ['url' => '/images/restaurant-wifi-qr.svg', 'title' => 'Restaurant WiFi QR Code', 'caption' => 'Professional WiFi QR codes for restaurants'],
            ],
            '/hotel-wifi-qr' => [
                ['url' => '/images/hotel-wifi-qr.svg', 'title' => 'Hotel WiFi QR Code', 'caption' => 'Elegant WiFi QR codes for hotels'],
            ],
        ];
    }

    private function generateUrlEntry($domain, $route, $currentDate)
    {
        $xml = "    <url>\n";
        $xml .= "        <loc>{$domain}{$route['url']}</loc>\n";
        $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
        $xml .= "        <changefreq>{$route['changefreq']}</changefreq>\n";
        $xml .= "        <priority>{$route['priority']}</priority>\n";
        $xml .= "    </url>\n";
        
        return $xml;
    }
}
