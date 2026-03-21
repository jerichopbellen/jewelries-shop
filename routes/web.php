<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController as ShopReview;
use App\Http\Controllers\Admin\ReviewController as AdminReview;
use App\Http\Controllers\Admin\DashboardController;



Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('orders', OrderController::class);
Route::resource('users', UserController::class);

Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/products/{product}/add-to-cart', [ShopController::class, 'addToCart'])->name('shop.addToCart');
Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
Route::delete('/cart/{product}', [ShopController::class, 'removeFromCart'])->name('shop.removeFromCart');
// Checkout
Route::get('/checkout', [ShopController::class, 'checkoutForm'])->name('shop.checkoutForm');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

Route::get('/shop/orders/history', [ShopController::class, 'orderHistory'])->name('shop.orders.history');
Route::get('/shop/orders', [ShopController::class, 'ordersIndex'])->name('shop.orders.index');
Route::get('/shop/orders/{order}', [ShopController::class, 'ordersShow'])->name('shop.orders.show');
Route::post('/shop/orders/{order}/cancel', [ShopController::class, 'cancel'])->name('shop.orders.cancel');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/reviews/{product}', [ShopReview::class, 'store'])->name('reviews.store');


Route::get('/admin/reviews', [AdminReview::class, 'index'])->name('admin.reviews.index');
Route::delete('/admin/reviews/{review}', [AdminReview::class, 'destroy'])->name('admin.reviews.destroy');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');