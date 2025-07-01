<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LanguageDetectionService;

class QrCodeController extends Controller
{
    protected $languageService;

    public function __construct(LanguageDetectionService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index()
    {
        return view('wifi-qr', [
            'pageType' => 'general',
            'title' => __('app.site_title'),
            'description' => __('app.site_description'),
            'keywords' => 'wifi qr code generator, free wifi qr code, qr code for wifi, wifi password qr code, custom wifi qr',
            'currentLocale' => $this->languageService->getCurrentLocale(),
            'supportedLanguages' => $this->languageService->getSupportedLanguages(),
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
}
