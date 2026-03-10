<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MollieController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('combo', [ComboController::class, 'index'])->name('combo');
Route::get('checkout', [PaymentController::class, 'index'])->name('checkout');
Route::post('paypal/handle', [PaypalController::class, 'handlePayment'])->name('paypal.handle');
Route::get('paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');
Route::get('paypal/success', [PaypalController::class, 'success'])->name('paypal.success');

Route::post('mollie/handle', [MollieController::class, 'handlePayment'])->name('mollie.handle');
Route::get('mollie/cancel', [MollieController::class, 'cancel'])->name('mollie.cancel');
Route::get('mollie/success', [MollieController::class, 'success'])->name('mollie.success');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('help-center', [HelpCenterController::class, 'index'])->name('help-center');
Route::get('product-detail/{product:slug}', [ProductController::class, 'detail'])->name('product-detail');
Route::get('package-detail/{package:slug}', [PackageController::class, 'detail'])->name('package-detail');

// Auth redirect for admin: unauthenticated users hitting admin go to admin login
Route::get('login', fn () => redirect()->route('admin.login'))->name('login');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login']);
    });
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('posts', AdminPostController::class)->except(['show']);
    });
});

Route::get('test', function () {
    return view('example');
})->name('test');
