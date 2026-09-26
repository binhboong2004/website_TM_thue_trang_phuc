<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Client\Auth\RegisteredUserController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\LookbookController;
use App\Http\Controllers\Client\PasswordController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\RentalOrderController;
use App\Http\Controllers\Client\VirtualFittingController;
use App\Http\Controllers\Client\WishlistController;
use App\Http\Controllers\Shop\DashboardController as ShopDashboardController;
use App\Http\Controllers\Shop\InventoryController as ShopInventoryController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:6,1');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');

Route::get('/shop', [CatalogController::class, 'index'])->name('client.shop');
Route::view('/collections/{category}', 'client.pages.collections.show')
    ->where('category', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('collections.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('products.show');
Route::view('/search', 'client.pages.search')->name('search');

Route::view('/brands', 'client.pages.brands.index')->name('client.brands');
Route::view('/brands/{brand}', 'client.pages.brands.show')
    ->where('brand', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('client.brands.show');
Route::get('/lookbook', [LookbookController::class, 'index'])->name('client.lookbook');
Route::get('/virtual-fitting', [VirtualFittingController::class, 'index'])->name('client.virtual-fitting');
Route::redirect('/ai-stylist', '/virtual-fitting', 301)->name('client.ai-stylist');

Route::middleware('auth')
    ->prefix('account')
    ->group(function (): void {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/password', [PasswordController::class, 'edit'])->name('account.password');
        Route::put('/password', [PasswordController::class, 'update'])->name('account.password.update');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('account.wishlist');
    });

Route::view('/checkout', 'client.pages.checkout')->name('checkout');
Route::get('/account/rentals/{order_code}', [RentalOrderController::class, 'show'])
    ->where('order_code', '[A-Za-z0-9-]+')
    ->name('account.rentals.show');

Route::prefix('shop')
    ->name('shop.')
    ->middleware(['auth', 'verified', 'is_shop'])
    ->group(function (): void {
        Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventory', [ShopInventoryController::class, 'index'])->name('inventory.index');

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
