<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Seller;
use App\Http\Controllers\Buyer;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public / Buyer Routes
Route::middleware(['track.viewed'])->group(function () {
    Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/products', [Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [Controllers\ProductController::class, 'show'])->name('products.show');
});

// Cart
Route::get('/cart', [Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [Controllers\CartController::class, 'remove'])->name('cart.remove');

// Protected Buyer Routes
Route::middleware(['auth', 'prevent.banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/dummy-payment/{orderNumber}', [Controllers\CheckoutController::class, 'dummyPayment'])->name('checkout.dummy-payment');
    Route::post('/checkout/dummy-payment/{orderNumber}', [Controllers\CheckoutController::class, 'processDummyPayment'])->name('checkout.process-dummy');

    // Buyer Panel
    Route::prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/dashboard', [Buyer\DashboardController::class, 'index'])->name('dashboard');
        
        // Orders
        Route::get('/orders', [Buyer\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [Buyer\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/complete', [Buyer\OrderController::class, 'complete'])->name('orders.complete');
        
        // Reviews
        Route::get('/orders/{order}/items/{item}/review', [Buyer\ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/orders/{order}/items/{item}/review', [Buyer\ReviewController::class, 'store'])->name('reviews.store');
    });

    // Seller Onboarding
    Route::get('/seller/onboarding', [Seller\SellerOnboardingController::class, 'index'])->name('seller.onboarding.index');
    Route::post('/seller/onboarding', [Seller\SellerOnboardingController::class, 'store'])->name('seller.onboarding.store');
    Route::get('/seller/onboarding/pending', [Seller\SellerOnboardingController::class, 'pending'])->name('seller.onboarding.pending');

    // Generic dashboard redirect for Breeze
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('super_admin')) {
            return redirect('/admin');
        } elseif ($user->hasRole('seller')) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('buyer.dashboard');
    })->name('dashboard');

    // Seller Panel
    Route::middleware(['role:seller', \App\Http\Middleware\EnsureStoreActive::class])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [Seller\SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', Seller\SellerProductController::class);
        
        Route::get('/orders', [Seller\SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [Seller\SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [Seller\SellerOrderController::class, 'updateStatus'])->name('orders.status.update');

        Route::get('/wallet', [Seller\SellerWalletController::class, 'index'])->name('wallet.index');
        Route::post('/wallet/withdraw', [Seller\SellerWalletController::class, 'withdraw'])->name('wallet.withdraw');
    });
});

require __DIR__.'/auth.php';
