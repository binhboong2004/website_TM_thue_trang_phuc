<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Shop\DashboardController as ShopDashboardController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/shop', 'client.pages.shop.index')->name('shop.index');
Route::view('/collections/{category}', 'client.pages.collections.show')
    ->where('category', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('collections.show');
Route::view('/products/{slug}', 'client.pages.products.show')
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('products.show');
Route::view('/search', 'client.pages.search')->name('search');

Route::view('/brands', 'client.pages.brands.index')->name('brands.index');
Route::view('/brands/{brand}', 'client.pages.brands.show')
    ->where('brand', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('brands.show');
Route::view('/lookbook', 'client.pages.lookbook.index')->name('lookbook.index');
Route::view('/ai-stylist', 'client.pages.ai-stylist')->name('ai-stylist');

Route::view('/checkout', 'client.pages.checkout')->name('checkout');
Route::view('/account/rentals/{order_code}', 'client.pages.account.rentals.show')
    ->where('order_code', '[A-Za-z0-9-]+')
    ->name('account.rentals.show');

Route::prefix('shop')
    ->name('shop.')
    ->middleware(['auth', 'verified', 'is_shop'])
    ->group(function (): void {
        Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');

        Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ShopProductController::class, 'create'])->name('products.create');
        Route::get('/products/{product}/edit', [ShopProductController::class, 'edit'])
            ->where('product', '[a-z0-9]+(?:-[a-z0-9]+)*')
            ->name('products.edit');

        Route::get('/orders', [ShopOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [ShopOrderController::class, 'show'])
            ->where('order', '[A-Za-z0-9-]+')
            ->name('orders.show');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
