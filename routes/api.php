<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Blog API Routes
Route::prefix('blog')->group(function () {
    // Get blogs list
    Route::get('/', [BlogController::class, 'index']);

    // Get featured blogs
    Route::get('/featured', [BlogController::class, 'featured']);

    // Search blogs
    Route::get('/search', [BlogController::class, 'search']);

    // Get blog statistics
    Route::get('/statistics', [BlogController::class, 'statistics']);

    // Get available languages
    Route::get('/languages', [BlogController::class, 'languages']);

    // Get categories
    Route::get('/categories', [BlogController::class, 'categories']);

    // Get tags
    Route::get('/tags', [BlogController::class, 'tags']);

    // Get blogs by category
    Route::get('/category/{categoryId}', [BlogController::class, 'byCategory']);

    // Get blogs by tag
    Route::get('/tag/{tagId}', [BlogController::class, 'byTag']);

    // Get single blog by slug
    Route::get('/{slug}', [BlogController::class, 'show']);
});
