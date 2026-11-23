<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\ProductManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Store Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [StoreController::class, 'index'])
    ->name('store.index');

Route::get('/products/{slug}', [StoreController::class, 'show'])
    ->name('store.show');

/*
|--------------------------------------------------------------------------
| Shopping Cart Routes
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{slug}', [CartController::class, 'add'])
    ->name('cart.add');

Route::patch('/cart/update/{productId}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])
    ->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Booking Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/products/{slug}/book', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/products/{slug}/book', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/my-bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::get('/my-bookings/{reference}', [BookingController::class, 'show'])
        ->name('bookings.show');
});

/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Booking management.
        Route::get('/bookings', [
            BookingManagementController::class,
            'index',
        ])->name('bookings.index');

        Route::get('/bookings/{reference}', [
            BookingManagementController::class,
            'show',
        ])->name('bookings.show');

        Route::patch('/bookings/{reference}/status', [
            BookingManagementController::class,
            'updateStatus',
        ])->name('bookings.update-status');

        // Product management.
        Route::get('/products', [
            ProductManagementController::class,
            'index',
        ])->name('products.index');

        Route::get('/products/create', [
            ProductManagementController::class,
            'create',
        ])->name('products.create');

        Route::post('/products', [
            ProductManagementController::class,
            'store',
        ])->name('products.store');

        Route::get('/products/{product}/edit', [
            ProductManagementController::class,
            'edit',
        ])->name('products.edit');

        Route::put('/products/{product}', [
            ProductManagementController::class,
            'update',
        ])->name('products.update');

        Route::delete('/products/{product}', [
            ProductManagementController::class,
            'destroy',
        ])->name('products.destroy');
    });