<?php

use App\Http\Controllers\ComboController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
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
Route::get('product-detail/{product:slug}', [ProductController::class, 'detail'])->name('product-detail');
Route::get('package-detail/{package:slug}', [PackageController::class, 'detail'])->name('package-detail');

// Route::group(['prefix' => 'admin'], function () {
//     Route::get('/', [DashboardController::class, 'index'])->name('home');
// });

Route::get('test', function () {
    return view('example');
})->name('test');
