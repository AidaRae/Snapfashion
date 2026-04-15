<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AdminSalesController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Authentication Required)
|--------------------------------------------------------------------------
| These routes are loaded by bootstrap/app.php with:
| - Prefix: /admin
| - Name prefix: admin.
| - Middleware: web
*/

// Admin Auth (No admin middleware)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::middleware(['admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::post('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk');
    Route::delete('/products/gallery-image/{image}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.gallery.delete');

    // Categories
    Route::get('/category', [AdminCategoryController::class, 'index'])->name('category');
    Route::get('/category/add', [AdminCategoryController::class, 'create'])->name('category.add');
    Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::get('/category/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('category.delete');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/order/add', [AdminOrderController::class, 'create'])->name('order.add');
    Route::post('/order/store', [AdminOrderController::class, 'store'])->name('order.store');
    Route::get('/order/details/{id}', [AdminOrderController::class, 'details'])->name('order.details');
    Route::get('/order/edit/{id}', [AdminOrderController::class, 'edit'])->name('order.edit');
    Route::post('/order/update/{id}', [AdminOrderController::class, 'update'])->name('order.update');
    Route::get('/order/delete/{id}', [AdminOrderController::class, 'destroy'])->name('order.delete');
    Route::get('/order/invoice/{id}', [AdminOrderController::class, 'invoice'])->name('order.invoice');

    // Customers (guest order data)
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers');
    Route::get('/customer/{email}', [AdminCustomerController::class, 'show'])->name('customer.show');

    // Coupons
    Route::resource('coupons', AdminCouponController::class);

    // Stocks
    Route::get('/stocks', [\App\Http\Controllers\Admin\AdminStockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks/{product}/update-stock', [\App\Http\Controllers\Admin\AdminStockController::class, 'update'])->name('stocks.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Sales Analytics
    Route::get('/sales', [AdminSalesController::class, 'index'])->name('sales.index');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::get('/settings/shipping', [AdminSettingController::class, 'shipping'])->name('settings.shipping');
    Route::put('/settings/shipping', [AdminSettingController::class, 'updateShipping'])->name('settings.shipping.update');
    Route::get('/settings/payment', [AdminSettingController::class, 'payment'])->name('settings.payment');
    Route::put('/settings/payment', [AdminSettingController::class, 'updatePayment'])->name('settings.payment.update');
    Route::get('/settings/email', [AdminSettingController::class, 'email'])->name('settings.email');
    Route::put('/settings/email', [AdminSettingController::class, 'updateEmail'])->name('settings.email.update');
    Route::post('/settings/email/test', [AdminSettingController::class, 'sendTestEmail'])->name('settings.email.test');
    Route::get('/settings/website', [AdminSettingController::class, 'webSettings'])->name('settings.website');
    Route::put('/settings/website', [AdminSettingController::class, 'updateWebInfo'])->name('settings.website.update');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
});