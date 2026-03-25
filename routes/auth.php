<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;

// User Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('password/reset', function () {
        return view('auth.forgot-password');
    })->name('password.request');
    
    Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('password/reset/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
});

// Admin Password Reset Routes  
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

