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

// SEO-friendly keyword-based routes (all redirect to main page with proper canonicals)
Route::get('/free-wifi-qr-code-generator', [App\Http\Controllers\QrCodeController::class, 'index'])->name('free-wifi-qr');
Route::get('/qr-code-for-wifi', [App\Http\Controllers\QrCodeController::class, 'index'])->name('qr-wifi');
Route::get('/wifi-qr-generator', [App\Http\Controllers\QrCodeController::class, 'index'])->name('wifi-generator');
Route::get('/custom-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'index'])->name('custom-wifi');
Route::get('/wifi-qr-code-with-logo', [App\Http\Controllers\QrCodeController::class, 'index'])->name('wifi-logo');

// Industry-specific landing pages
Route::get('/restaurant-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'restaurant'])->name('restaurant-wifi');
Route::get('/hotel-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'hotel'])->name('hotel-wifi');
Route::get('/office-wifi-qr', [App\Http\Controllers\QrCodeController::class, 'office'])->name('office-wifi');

// Content/Blog pages for SEO
Route::get('/blog', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('blog');
Route::get('/guide', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('guide');
Route::get('/how-to-create-wifi-qr-code', [App\Http\Controllers\QrCodeController::class, 'blog'])->name('how-to');
