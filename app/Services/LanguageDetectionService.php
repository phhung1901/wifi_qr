<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageDetectionService
{
    /**
     * Supported languages with their locale codes and country mappings
     */
    private const SUPPORTED_LANGUAGES = [
        'en' => ['countries' => ['US', 'GB', 'AU', 'CA', 'NZ', 'IE', 'ZA'], 'name' => 'English'],
        'vi' => ['countries' => ['VN'], 'name' => 'Tiếng Việt'],
        'zh' => ['countries' => ['CN', 'TW', 'HK', 'SG'], 'name' => '中文'],
        'ko' => ['countries' => ['KR'], 'name' => '한국어'],
        'ja' => ['countries' => ['JP'], 'name' => '日本語'],
        'es' => ['countries' => ['ES', 'MX', 'AR', 'CO', 'PE', 'VE', 'CL', 'EC', 'GT', 'CU', 'BO', 'DO', 'HN', 'PY', 'SV', 'NI', 'CR', 'PA', 'UY', 'PR'], 'name' => 'Español'],
        'id' => ['countries' => ['ID'], 'name' => 'Bahasa Indonesia'],
        'fr' => ['countries' => ['FR', 'BE', 'CH', 'CA', 'LU', 'MC'], 'name' => 'Français'],
        'de' => ['countries' => ['DE', 'AT', 'CH', 'LU'], 'name' => 'Deutsch'],
        'hi' => ['countries' => ['IN'], 'name' => 'हिन्दी'],
    ];

    /**
     * Browser language to locale mapping
     */
    private const BROWSER_LANGUAGE_MAP = [
        'en' => 'en',
        'en-us' => 'en',
        'en-gb' => 'en',
        'en-au' => 'en',
        'en-ca' => 'en',
        'vi' => 'vi',
        'vi-vn' => 'vi',
        'zh' => 'zh',
        'zh-cn' => 'zh',
        'zh-tw' => 'zh',
        'zh-hk' => 'zh',
        'ko' => 'ko',
        'ko-kr' => 'ko',
        'ja' => 'ja',
        'ja-jp' => 'ja',
        'es' => 'es',
        'es-es' => 'es',
        'es-mx' => 'es',
        'es-ar' => 'es',
        'id' => 'id',
        'id-id' => 'id',
        'fr' => 'fr',
        'fr-fr' => 'fr',
        'fr-ca' => 'fr',
        'de' => 'de',
        'de-de' => 'de',
        'de-at' => 'de',
        'hi' => 'hi',
        'hi-in' => 'hi',
    ];

    /**
     * Detect and set the appropriate language for the user
     */
    public function detectAndSetLanguage(Request $request): string
    {
        // Check if language is already set in session
        if (Session::has('locale') && $this->isValidLocale(Session::get('locale'))) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            return $locale;
        }

        // Try to detect from browser language
        $detectedLocale = $this->detectFromBrowser($request);
        
        // If browser detection fails, try IP-based detection (simplified)
        if (!$detectedLocale) {
            $detectedLocale = $this->detectFromIP($request);
        }

        // Fall back to English if no detection works
        $locale = $detectedLocale ?: 'en';

        // Set the locale
        App::setLocale($locale);
        Session::put('locale', $locale);

        return $locale;
    }

    /**
     * Set a specific language
     */
    public function setLanguage(string $locale): bool
    {
        if (!$this->isValidLocale($locale)) {
            return false;
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return true;
    }

    /**
     * Get all supported languages
     */
    public function getSupportedLanguages(): array
    {
        return self::SUPPORTED_LANGUAGES;
    }

    /**
     * Get current locale
     */
    public function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Check if a locale is valid/supported
     */
    public function isValidLocale(string $locale): bool
    {
        return array_key_exists($locale, self::SUPPORTED_LANGUAGES);
    }

    /**
     * Detect language from browser Accept-Language header
     */
    private function detectFromBrowser(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }

        // Parse Accept-Language header
        $languages = [];
        $parts = explode(',', $acceptLanguage);
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, ';') !== false) {
                [$lang, $quality] = explode(';', $part, 2);
                $quality = (float) str_replace('q=', '', $quality);
            } else {
                $lang = $part;
                $quality = 1.0;
            }
            
            $lang = strtolower(trim($lang));
            $languages[$lang] = $quality;
        }

        // Sort by quality (preference)
        arsort($languages);

        // Find the best match
        foreach ($languages as $lang => $quality) {
            if (isset(self::BROWSER_LANGUAGE_MAP[$lang])) {
                return self::BROWSER_LANGUAGE_MAP[$lang];
            }
            
            // Try with just the language part (before hyphen)
            $langPart = explode('-', $lang)[0];
            if (isset(self::BROWSER_LANGUAGE_MAP[$langPart])) {
                return self::BROWSER_LANGUAGE_MAP[$langPart];
            }
        }

        return null;
    }

    /**
     * Simple IP-based country detection (basic implementation)
     * In production, you might want to use a service like MaxMind GeoIP
     */
    private function detectFromIP(Request $request): ?string
    {
        // This is a simplified implementation
        // In a real application, you would use a GeoIP service
        
        $ip = $request->ip();
        
        // Skip local/private IPs
        if ($this->isPrivateIP($ip)) {
            return null;
        }

        // For demo purposes, we'll use a simple approach
        // In production, integrate with a GeoIP service like MaxMind
        
        return null; // Return null for now, browser detection should handle most cases
    }

    /**
     * Check if IP is private/local
     */
    private function isPrivateIP(string $ip): bool
    {
        return !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Get language name for a locale
     */
    public function getLanguageName(string $locale): string
    {
        return self::SUPPORTED_LANGUAGES[$locale]['name'] ?? $locale;
    }

    /**
     * Get language direction (for future RTL support)
     */
    public function getLanguageDirection(string $locale): string
    {
        // All current languages are LTR
        // Add RTL languages here when needed (ar, he, fa, etc.)
        return 'ltr';
    }
}
