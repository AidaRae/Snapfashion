<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderPaymentController;

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (Guest - No Authentication Required)
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('shop.home');

// Products
Route::get('/shop', [ProductController::class, 'index'])->name('shop.products');
Route::get('/shop/category/{category:slug}', [ProductController::class, 'byCategory'])->name('shop.category');
Route::get('/shop/product/{product:slug}', [ProductController::class, 'show'])->name('shop.product.show');
Route::get('/shop/search', [ProductController::class, 'search'])->name('shop.search');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('shop.about');

// Cart (Session-Based - No Auth)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::get('/cart/data', [CartController::class, 'getData'])->name('cart.data');

// Wishlist
Route::middleware(['web'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
 
    // Rate-limited: 30 toggles per minute per user
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle')
        ->middleware('throttle:30,1');
});
 

// Checkout (Guest - No Auth Required) Phase 1
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Order Payment Phase 2
Route::get('/order/{order:tracking_code}/pay', [OrderPaymentController::class, 'pay'])->name('order.pay');
Route::post('/order/{order:tracking_code}/pay/process', [OrderPaymentController::class, 'process'])->name('order.pay.process');
Route::get('/checkout/callback', [OrderPaymentController::class, 'callback'])->name('checkout.callback');
Route::get('/checkout/flutterwave/callback', [OrderPaymentController::class, 'flutterwaveCallback'])->name('checkout.flutterwave.callback');

// Order Tracking (Front-end form & via email link)
Route::get('/track-order', [PageController::class, 'trackOrderForm'])->name('shop.track.form');
Route::get('/order/track/{order:tracking_code}', [PageController::class, 'trackOrder'])->name('order.track');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('page.contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('page.terms');

/*
|--------------------------------------------------------------------------
| DEV-ONLY ROUTES (local environment)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/dev/mail-preview', function () {
        $order = \App\Models\Order::with('items.product')->latest()->firstOrFail();
        return new \App\Mail\OrderConfirmationMail($order);
    });
    Route::get('/dev/mail-preview/status', function () {
        $order = \App\Models\Order::with('items.product')->latest()->firstOrFail();
        return new \App\Mail\OrderStatusUpdatedMail($order);
    });
}

