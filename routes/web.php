<?php

use App\Http\Controllers\ComboController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('combo', [ComboController::class, 'index'])->name('combo');
Route::get('checkout', [PaymentController::class, 'index'])->name('checkout');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('help-center', [HelpCenterController::class, 'index'])->name('help-center');
Route::get('product-detail', [ProductController::class, 'detail'])->name('product-detail');

// Route::group(['prefix' => '/'], function () {
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });
