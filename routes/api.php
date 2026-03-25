<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Profile Management
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage']);
    
    // Professional Profile
    Route::apiResource('professional-profiles', ProfessionalProfileController::class);
    
    // Jobs
    Route::apiResource('jobs', JobController::class);
    Route::get('/jobs/{job}/bids', [JobController::class, 'bids']);
    
    // Bids
    Route::post('/jobs/{job}/bids', [BidController::class, 'store']);
    Route::put('/bids/{bid}', [BidController::class, 'update']);
    Route::delete('/bids/{bid}', [BidController::class, 'destroy']);
    Route::post('/bids/{bid}/accept', [BidController::class, 'accept']);
    
    // Messaging
    Route::get('/conversations', [MessageController::class, 'conversations']);
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'messages']);
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'sendMessage']);
    Route::post('/conversations/start', [MessageController::class, 'startConversation']);
    
    // Stores
    Route::apiResource('stores', StoreController::class);
    Route::get('/my-store', [StoreController::class, 'myStore']);
    
    // Products
    Route::apiResource('products', ProductController::class);
    Route::get('/stores/{store}/products', [ProductController::class, 'storeProducts']);
    
    // Payments
    Route::post('/payments/initialize', [PaymentController::class, 'initialize']);
    Route::post('/payments/verify/{reference}', [PaymentController::class, 'verify']);
    Route::post('/payments/release/{transaction}', [PaymentController::class, 'release']);
    Route::post('/payments/dispute/{transaction}', [PaymentController::class, 'dispute']);
    
    // Reviews
    Route::apiResource('reviews', ReviewController::class);
    Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);
    
    // Search
    Route::get('/search/jobs', [SearchController::class, 'jobs']);
    Route::get('/search/professionals', [SearchController::class, 'professionals']);
    Route::get('/search/products', [SearchController::class, 'products']);
    Route::get('/search/stores', [SearchController::class, 'stores']);
    
    // Location-based search
    Route::get('/nearby/stores', [SearchController::class, 'nearbyStores']);
    Route::get('/nearby/products', [SearchController::class, 'nearbyProducts']);
    Route::get('/nearby/jobs', [SearchController::class, 'nearbyJobs']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::apiResource('users', AdminUserController::class);
    Route::put('/users/{user}/verify', [AdminUserController::class, 'verify']);
    Route::put('/users/{user}/suspend', [AdminUserController::class, 'suspend']);
    Route::get('/disputes', [AdminController::class, 'disputes']);
    Route::post('/disputes/{dispute}/resolve', [AdminController::class, 'resolveDispute']);
});