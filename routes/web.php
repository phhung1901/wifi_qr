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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wifi-qr', [App\Http\Controllers\QrCodeController::class, 'index'])->name('wifi-qr');
Route::post('/wifi-qr/generate', [App\Http\Controllers\QrCodeController::class, 'generate'])->name('wifi-qr.generate');
Route::post('/wifi-qr/poster', [App\Http\Controllers\QrCodeController::class, 'generatePoster'])->name('wifi-qr.poster');
