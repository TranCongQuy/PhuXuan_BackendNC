<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── TRANG CHỦ ───────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── ABOUT ────────────────────────────────────────────────────
Route::get('/about', function () {
    return view('about');
})->name('about');

// ─── CONTACT ──────────────────────────────────────────────────
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ─── ARTICLES (Buổi 2) ───────────────────────────────────────
Route::resource('articles', ArticleController::class);

// ─── BLOG (Buổi 1) ───────────────────────────────────────────
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// ─── DASHBOARD ─────────────────────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ─── PUBLIC POST ROUTES ──────────────────────────────────────
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// ─── CATEGORIES ───────────────────────────────────────────────
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// ─── SHOP ROUTES ──────────────────────────────────────────────
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
});

// ─── PROTECTED POST ROUTES ────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Comment routes (thêm mới)
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comment');
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');

    Route::get('/posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
    Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    Route::middleware(['post.owner'])->group(function () {
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::patch('/posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    });
});

// ─── PUBLIC SHOW ──────────────────────────────────────────────
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// ─── AUTH ROUTES ──────────────────────────────────────────────
require __DIR__ . '/auth.php';