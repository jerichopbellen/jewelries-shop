<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController as AdminReview;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController as ShopReview;


Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Cart & Checkout
    Route::post('/products/{product}/add-to-cart', [ShopController::class, 'addToCart'])->name('shop.addToCart');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::delete('/cart/{product}', [ShopController::class, 'removeFromCart'])->name('shop.removeFromCart');
    Route::get('/checkout', [ShopController::class, 'checkoutForm'])->name('shop.checkoutForm');
    Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

    // Reviews
    Route::post('/reviews/{product}', [ShopReview::class, 'store'])->name('reviews.store');

    // Customer Order Management
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/orders', [ShopController::class, 'ordersIndex'])->name('orders.index');
        Route::get('/orders/history', [ShopController::class, 'orderHistory'])->name('orders.history');
        Route::get('/orders/{order}', [ShopController::class, 'ordersShow'])->name('orders.show');
        Route::post('/orders/{order}/cancel', [ShopController::class, 'cancel'])->name('orders.cancel');
    });

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
    });
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Products
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);

    // Resources
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);

    // Admin Reviews
    Route::get('/reviews', [AdminReview::class, 'index'])->name('admin.reviews.index');
    Route::delete('/reviews/{review}', [AdminReview::class, 'destroy'])->name('admin.reviews.destroy');
});