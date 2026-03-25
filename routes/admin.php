<?php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest routes (not logged in)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
        
        // Password reset routes
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    });

    // Protected routes (logged in)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
        // Other admin routes...
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class);
        Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class);
        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('stores', \App\Http\Controllers\Admin\StoreController::class);
        Route::get('settings', function () {
            return view('admin.settings');
        })->name('settings');
        Route::get('profile/edit', function () {
            return view('admin.profile.edit');
        })->name('profile.edit');
        Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('stores/{store}/toggle-verification', [\App\Http\Controllers\Admin\StoreController::class, 'toggleVerification'])->name('stores.toggle-verification');
    });
});
