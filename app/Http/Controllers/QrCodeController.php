<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LanguageDetectionService;
use App\Services\StatisticsService;
use App\Services\DownloadTrackingService;

class QrCodeController extends Controller
{
    protected $languageService;
    protected $statisticsService;
    protected $downloadTrackingService;

    public function __construct(
        LanguageDetectionService $languageService,
        StatisticsService $statisticsService,
        DownloadTrackingService $downloadTrackingService
    ) {
        $this->languageService = $languageService;
        $this->statisticsService = $statisticsService;
        $this->downloadTrackingService = $downloadTrackingService;
    }

    public function index()
    {
        // Simulate background activity
        $this->statisticsService->simulateActivity();

        return view('wifi-qr', [
            'pageType' => 'general',
            'title' => __('app.site_title'),
            'description' => __('app.site_description'),
            'keywords' => 'wifi qr code generator, free wifi qr code, qr code for wifi, wifi password qr code, custom wifi qr',
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
            'currentStats' => $this->statisticsService->getLiveCount(),
        ]);
    }

    public function restaurant()
    {
        return view('wifi-qr', [
            'pageType' => 'restaurant',
            'title' => __('app.site_title') . ' - Restaurant',
            'description' => __('app.site_description'),
            'keywords' => 'restaurant wifi qr code, cafe wifi qr, restaurant qr code generator, dining wifi access, table wifi qr',
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
        ]);
    }

    public function hotel()
    {
        return view('wifi-qr', [
            'pageType' => 'hotel',
            'title' => __('app.site_title') . ' - Hotel',
            'description' => __('app.site_description'),
            'keywords' => 'hotel wifi qr code, guest wifi qr, accommodation wifi access, hotel qr generator, hospitality wifi',
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
        ]);
    }

    public function office()
    {
        return view('wifi-qr', [
            'pageType' => 'office',
            'title' => __('app.site_title') . ' - Office',
            'description' => __('app.site_description'),
            'keywords' => 'office wifi qr code, business wifi qr, coworking wifi access, professional wifi qr, guest wifi office',
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
        ]);
    }

    public function blog()
    {
        return view('blog', [
            'title' => __('app.blog_title'),
            'description' => __('app.blog_description'),
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
        ]);
    }

    public function setLanguage(Request $request)
    {
        $locale = $request->input('locale');

        if ($this->languageService->setLanguage($locale)) {
            return response()->json([
                'success' => true,
                'locale' => $locale,
                'message' => 'Language changed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid language'
        ], 400);
    }

    /**
     * Get current statistics for real-time updates
     */
    public function getStats()
    {
        return response()->json([
            'count' => $this->statisticsService->getLiveCount(),
            'formatted' => $this->statisticsService->getFormattedCount(),
            'timestamp' => time()
        ]);
    }

    /**
     * Increment QR generation count (called when user generates QR)
     */
    public function incrementStats()
    {
        $this->statisticsService->incrementQrGenerated();

        return response()->json([
            'success' => true,
            'count' => $this->statisticsService->getLiveCount(),
            'formatted' => $this->statisticsService->getFormattedCount()
        ]);
    }

    /**
     * Track QR code download
     */
    public function trackDownload(Request $request)
    {
        $options = [
            'type' => $request->input('type', 'png'),
            'ssid' => $request->input('ssid'),
            'has_logo' => $request->boolean('has_logo'),
            'has_custom_colors' => $request->boolean('has_custom_colors')
        ];

        $download = $this->downloadTrackingService->trackDownload($request, $options);

        // Also increment the fake counter for public display
        $this->statisticsService->incrementQrGenerated();

        return response()->json([
            'success' => true,
            'download_id' => $download->id,
            'message' => 'Download tracked successfully'
        ]);
    }
}
