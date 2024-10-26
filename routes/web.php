<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'list'])->name('home');
Route::get('/detail/{product}', [HomeController::class, 'detail'])->name('product.detail');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('cart')->group(function () {
        Route::get('/', [HomeController::class, 'viewCart'])->name('cart.view');
        Route::post('/item-add/{product}', [HomeController::class, 'addCart'])->name('cart.add');
        Route::post('/cart-purchase', [HomeController::class, 'cartPurchase'])->name('cart.purchase');
        Route::post('/cart-delete', [HomeController::class, 'cartDelete'])->name('cart.delete');
        Route::post('/item-delete/{product}', [HomeController::class, 'removeCart'])->name('cart.remove');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/export', [OrderController::class, 'export'])->name('orders.export');
        Route::get('/show/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/export', [ProductController::class, 'export'])->name('products.export');
        Route::get('/show/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/update/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/export', [CustomerController::class, 'export'])->name('customers.export');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    });
});

require __DIR__.'/auth.php';
