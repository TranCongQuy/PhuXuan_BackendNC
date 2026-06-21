<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;

// ─── Routes độc lập ─────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ─── Route Group với prefix /shop ───────────────────────────
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', function () {
        return view('shop.products');
    })->name('products');

    Route::get('/cart', function () {
        return view('shop.cart');
    })->name('cart');
});

// ─── Articles ───────────────────────────────────────────────
Route::resource('articles', ArticleController::class);

// ─── Blog ───────────────────────────────────────────────────
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// ─── Posts (Soft Delete) ──────────────────────────────────
// QUAN TRỌNG: Đặt các route cụ thể TRƯỚC Route::resource()
Route::get('/posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

// Resource route cho posts (CRUD + soft delete)
Route::resource('posts', PostController::class);