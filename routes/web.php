<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main routes
Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('home');
Route::get('/wifi-qr', [App\Http\Controllers\QrCodeController::class, 'index'])->name('wifi-qr');

// Language switching
Route::post('/set-language', [App\Http\Controllers\QrCodeController::class, 'setLanguage'])->name('set-language');

// SEO-friendly keyword-based routes with optimized landing pages
Route::get('/free-wifi-qr-code-generator', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('free-wifi-qr');
Route::get('/qr-code-for-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('qr-wifi');
Route::get('/wifi-qr-generator', [App\Http\Controllers\QrCodeController::class, 'wifiQrGenerator'])->name('wifi-generator');
Route::get('/custom-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'customWifiQr'])->name('custom-wifi');
Route::get('/wifi-qr-code-with-logo', [App\Http\Controllers\QrCodeController::class, 'wifiQrWithLogo'])->name('wifi-logo');

// Additional high-value keyword routes
Route::get('/wifi-password-qr-code', [App\Http\Controllers\QrCodeController::class, 'wifiPasswordQr'])->name('wifi-password-qr');
Route::get('/wifi-qr-code-maker', [App\Http\Controllers\QrCodeController::class, 'wifiQrMaker'])->name('wifi-qr-maker');
Route::get('/generate-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'generateWifiQr'])->name('generate-wifi-qr');
Route::get('/instant-wifi-connection', [App\Http\Controllers\QrCodeController::class, 'instantWifiConnection'])->name('instant-wifi');
Route::get('/business-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'businessWifiQr'])->name('business-wifi-qr');

// Industry-specific landing pages
Route::get('/restaurant-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'restaurant'])->name('restaurant-wifi');
Route::get('/hotel-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'hotel'])->name('hotel-wifi');
Route::get('/office-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'office'])->name('office-wifi');
Route::get('/cafe-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'cafe'])->name('cafe-wifi');
Route::get('/event-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'event'])->name('event-wifi');
Route::get('/retail-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'retail'])->name('retail-wifi');

// Multilingual SEO routes
Route::prefix('es')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('es.home');
    Route::get('/generador-codigo-qr-wifi-gratis', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('es.free-wifi-qr');
    Route::get('/codigo-qr-para-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('es.qr-wifi');
});

Route::prefix('fr')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('fr.home');
    Route::get('/generateur-code-qr-wifi-gratuit', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('fr.free-wifi-qr');
    Route::get('/code-qr-pour-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('fr.qr-wifi');
});

Route::prefix('de')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('de.home');
    Route::get('/kostenloser-wifi-qr-code-generator', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('de.free-wifi-qr');
    Route::get('/qr-code-fuer-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('de.qr-wifi');
});

// Chinese routes
Route::prefix('zh')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('zh.home');
    Route::get('/免费wifi二维码生成器', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('zh.free-wifi-qr');
    Route::get('/wifi二维码', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('zh.qr-wifi');
});

// Japanese routes
Route::prefix('ja')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('ja.home');
    Route::get('/無料wifi-qrコード生成器', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('ja.free-wifi-qr');
    Route::get('/wifi-qrコード', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('ja.qr-wifi');
});

// Korean routes
Route::prefix('ko')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('ko.home');
    Route::get('/무료-wifi-qr코드-생성기', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('ko.free-wifi-qr');
    Route::get('/wifi-qr코드', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('ko.qr-wifi');
});

// Vietnamese routes
Route::prefix('vi')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('vi.home');
    Route::get('/tao-ma-qr-wifi-mien-phi', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('vi.free-wifi-qr');
    Route::get('/ma-qr-cho-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('vi.qr-wifi');
});

// Hindi routes
Route::prefix('hi')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('hi.home');
    Route::get('/मुफ्त-wifi-qr-कोड-जेनरेटर', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('hi.free-wifi-qr');
    Route::get('/wifi-के-लिए-qr-कोड', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('hi.qr-wifi');
});

// Indonesian routes
Route::prefix('id')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index'])->name('id.home');
    Route::get('/generator-qr-code-wifi-gratis', [App\Http\Controllers\QrCodeController::class, 'freeWifiQr'])->name('id.free-wifi-qr');
    Route::get('/qr-code-untuk-wifi', [App\Http\Controllers\QrCodeController::class, 'qrForWifi'])->name('id.qr-wifi');
});

// Content/Blog pages for SEO
Route::get('/blog', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('blog');
Route::get('/guide', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('guide');
Route::get('/how-to-create-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('how-to');

// Language switching
Route::post('/change-language', [App\Http\Controllers\QrCodeController::class, 'changeLanguage'])->name('change-language');

// Statistics API
Route::get('/api/stats', [App\Http\Controllers\QrCodeController::class, 'getStats'])->name('api.stats');
Route::post('/api/stats/increment', [App\Http\Controllers\QrCodeController::class, 'incrementStats'])->name('api.stats.increment');
Route::post('/api/track-download', [App\Http\Controllers\QrCodeController::class, 'trackDownload'])->name('api.track.download');

// SEO and Sitemap routes
Route::get('/sitemap.xml', function() {
    return response()->file(public_path('sitemap.xml'), ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/sitemap-images.xml', function() {
    return response()->file(public_path('sitemap-images.xml'), ['Content-Type' => 'application/xml']);
})->name('sitemap.images');

Route::get('/sitemap-index.xml', function() {
    return response()->file(public_path('sitemap-index.xml'), ['Content-Type' => 'application/xml']);
})->name('sitemap.index');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/stats-range', [App\Http\Controllers\Admin\DashboardController::class, 'getStatsForRange'])->name('admin.stats.range');
    Route::get('/export-csv', [App\Http\Controllers\Admin\DashboardController::class, 'exportCsv'])->name('admin.export.csv');
});
