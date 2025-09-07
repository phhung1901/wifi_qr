<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LanguageDetectionService;

class DetectLanguage
{
    protected $languageService;

    public function __construct(LanguageDetectionService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if language is set in URL prefix (e.g., /vi/blogs, /en/blogs)
        $path = $request->path();
        $segments = explode('/', $path);

        if (count($segments) > 0 && $this->languageService->isValidLocale($segments[0])) {
            // Set language from URL prefix
            $this->languageService->setLanguage($segments[0]);
        } else {
            // Check if user is manually setting language
            if ($request->has('lang')) {
                $requestedLang = $request->get('lang');
                if ($this->languageService->setLanguage($requestedLang)) {
                    // Redirect to clean URL without lang parameter
                    return redirect($request->url());
                }
            } else {
                // Auto-detect and set language
                $this->languageService->detectAndSetLanguage($request);
            }
        }

        return $next($request);
    }
}
