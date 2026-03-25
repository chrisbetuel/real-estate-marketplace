<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeSearchController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ProfessionalDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Public Search & Listings
|--------------------------------------------------------------------------
*/
Route::get('/search/jobs', [SearchController::class, 'jobs'])->name('search.jobs');
Route::get('/search/professionals', [SearchController::class, 'professionals'])->name('search.professionals');
Route::get('/search/products', [SearchController::class, 'products'])->name('search.products');
Route::get('/search/stores', [SearchController::class, 'stores'])->name('search.stores');

Route::resource('properties', PropertyController::class);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Smart Dashboard Redirect
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->user_type) {
            'professional' => redirect()->route('professional.dashboard'),
            'store_owner' => redirect()->route('store.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('client.dashboard'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Role-Based Dashboards
    |--------------------------------------------------------------------------
    */

    // 🔹 Client
    Route::prefix('client')->middleware(['client'])->name('client.')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/jobs', [ClientDashboardController::class, 'jobs'])->name('jobs');
        Route::get('/jobs/{job}/bids', [ClientDashboardController::class, 'jobBids'])->name('job-bids');
        Route::post('/bids/{bid}/accept', [ClientDashboardController::class, 'acceptBid'])->name('accept-bid');
        Route::post('/bids/{bid}/reject', [ClientDashboardController::class, 'rejectBid'])->name('reject-bid');
        Route::post('/jobs/{job}/complete', [ClientDashboardController::class, 'completeJob'])->name('complete-job');
    });

    // 🔹 Professional
    Route::prefix('professional')->middleware(['professional'])->name('professional.')->group(function () {
        Route::get('/dashboard', [ProfessionalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/bids', [ProfessionalDashboardController::class, 'bids'])->name('bids');
        Route::get('/bids/{id}', [ProfessionalDashboardController::class, 'bidDetails'])->name('bid-details');
        Route::get('/bids/{id}/edit', [ProfessionalDashboardController::class, 'editBid'])->name('edit-bid');
        Route::put('/bids/{id}', [ProfessionalDashboardController::class, 'updateBid'])->name('update-bid');
        Route::delete('/bids/{id}', [ProfessionalDashboardController::class, 'withdrawBid'])->name('withdraw-bid');
        Route::get('/jobs', [ProfessionalDashboardController::class, 'jobs'])->name('jobs');
        Route::patch('/jobs/{id}/status', [ProfessionalDashboardController::class, 'updateJobStatus'])->name('update-job-status');
    });

    // 🔹 Store
    Route::get('/store/dashboard', [StoreController::class, 'dashboard'])->name('store.dashboard');

    // 🔹 Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Jobs & Bids
    |--------------------------------------------------------------------------
    */
    Route::resource('jobs', JobController::class);
    Route::get('/jobs/{job}/bids', [JobController::class, 'bids'])->name('jobs.bids');

    Route::post('/jobs/{job}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::put('/bids/{bid}', [BidController::class, 'update'])->name('bids.update');
    Route::delete('/bids/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');
    Route::post('/bids/{bid}/accept', [BidController::class, 'accept'])->name('bids.accept');
    Route::post('/bids/{bid}/reject', [BidController::class, 'reject'])->name('bids.reject');

    /*
    |--------------------------------------------------------------------------
    | Products & Stores
    |--------------------------------------------------------------------------
    */
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/viewing-request', [ProductController::class, 'viewingRequest'])
        ->name('products.viewing-request');

    Route::resource('stores', StoreController::class);
    Route::get('/my-store', [StoreController::class, 'myStore'])->name('stores.my');
    Route::get('/stores/{store}/products', [StoreController::class, 'products'])->name('stores.products');

    /*
    |--------------------------------------------------------------------------
    | Professionals
    |--------------------------------------------------------------------------
    */
    Route::resource('professionals', ProfessionalController::class);

    /*
    |--------------------------------------------------------------------------
    | Search (Nearby)
    |--------------------------------------------------------------------------
    */
    Route::get('/search/nearby', [HomeSearchController::class, 'search'])->name('search.nearby');
    Route::get('/place/details', [HomeSearchController::class, 'getPlaceDetails'])->name('place.details');

    /*
    |--------------------------------------------------------------------------
    | Messaging
    |--------------------------------------------------------------------------
    */
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/start/{job}', [MessageController::class, 'start'])->name('start-job');
        Route::get('/start-store/{store}', [MessageController::class, 'startStoreConversation'])->name('start-store');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [MessageController::class, 'send'])->name('send');
    });

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */
    Route::resource('reviews', ReviewController::class)->except(['index', 'create']);
    Route::post('/reviews/{job}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');
});

/*
|--------------------------------------------------------------------------
| Admin Extra
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
});

/*
|--------------------------------------------------------------------------
| External Route Files
|--------------------------------------------------------------------------
*/
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';