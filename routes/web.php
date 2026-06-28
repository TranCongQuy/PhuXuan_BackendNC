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

// ─── DASHBOARD ─────────────────────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ─── PUBLIC POST ROUTES (không cần login) ───────────────────
// Chỉ index và show là public – show đặt SAU create để tránh xung đột
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// ─── CATEGORIES (công khai) ──────────────────────────────────
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// ─── SHOP ROUTES (public) ────────────────────────────────────
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
});

// ─── PROTECTED POST ROUTES (cần login) ──────────────────────
Route::middleware(['auth'])->group(function () {
    // create phải đặt TRƯỚC show và nằm trong auth
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Thùng rác & khôi phục (cần auth)
    Route::get('/posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
    Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    // Sửa / Xóa (cần auth + owner)
    Route::middleware(['post.owner'])->group(function () {
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Thêm route publish (cần auth + owner, admin bypass trong middleware)
    Route::patch('/posts/{post}/publish', [PostController::class, 'publish'])
        ->name('posts.publish')
        ->middleware('post.owner');
});

// ─── PUBLIC SHOW (đặt SAU tất cả route có path cụ thể) ──────
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// ─── AUTH ROUTES (Breeze) ─────────────────────────────────────
require __DIR__ . '/auth.php';