<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ─── SHOP ROUTES ──────────────────────────────────────────────
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', function () {
        return 'Danh sách sản phẩm';
    })->name('products');

    Route::get('/cart', function () {
        return 'Giỏ hàng';
    })->name('cart');
});

// ─── POST ROUTES ──────────────────────────────────────────────
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::resource('posts', PostController::class)->except(['index']);

require __DIR__ . '/auth.php';