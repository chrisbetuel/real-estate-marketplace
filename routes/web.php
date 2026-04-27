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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StoreDashboardController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PosController;

use App\Http\Controllers\ServiceEcosystemController;

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
Route::view('/our-story', 'our-story')->name('our-story');
Route::view('/how-it-works', 'how-it-works')->name('how-it-works');
Route::view('/team', 'team')->name('team');
Route::view('/copyright', 'copyright')->name('copyright');
Route::view('/disclaimer', 'disclaimer')->name('disclaimer');

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

// Public professionals listing
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');

/*
|--------------------------------------------------------------------------
| Store Front (Client Shopping)
|--------------------------------------------------------------------------
*/
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/stores', [StoreFrontController::class, 'stores'])->name('stores');
    Route::get('/stores/{id}', [StoreFrontController::class, 'store'])->name('store');
    Route::get('/products', [StoreFrontController::class, 'products'])->name('products');
    Route::get('/product/{id}', [StoreFrontController::class, 'product'])->name('product');
    
    // Cart routes (authenticated)
    Route::middleware(['auth'])->group(function () {
        Route::post('/cart/add/{productId}', [StoreFrontController::class, 'addToCart'])->name('add-to-cart');
        Route::get('/cart', [StoreFrontController::class, 'cart'])->name('cart');
        Route::post('/cart/update/{cartItemId}', [StoreFrontController::class, 'updateCart'])->name('update-cart');
        Route::delete('/cart/remove/{cartItemId}', [StoreFrontController::class, 'removeFromCart'])->name('remove-from-cart');
        
        // Checkout routes
        Route::get('/checkout', [StoreFrontController::class, 'checkout'])->name('checkout');
        Route::get('/escrow-job/{bid}', [PaymentController::class, 'showEscrowJob'])->name('payment.escrow-job');
        Route::post('/order', [StoreFrontController::class, 'processOrder'])->name('process-order');
        Route::get('/order/{orderId}/confirmation', [StoreFrontController::class, 'orderConfirmation'])->name('order-confirmation');
        
        // My orders
        Route::get('/my-orders', [StoreFrontController::class, 'myOrders'])->name('my-orders');
        Route::get('/order/{order}', [StoreFrontController::class, 'orderDetails'])->name('order-details');
        Route::get('/order/{order}/track', [StoreFrontController::class, 'trackOrder'])->name('order.track');
        Route::post('/orders/{order}/confirm', [StoreFrontController::class, 'confirmReceipt'])->name('orders.confirm-receipt');
    });
});

Route::resource('properties', PropertyController::class);

/*
|--------------------------------------------------------------------------
| POS Routes (Independent — any authenticated user)
|--------------------------------------------------------------------------
*/
Route::prefix('pos')->name('pos.')->middleware('auth')->group(function () {
    Route::get('/single-shop', [PosController::class, 'singleShop'])->name('single-shop');
    Route::get('/multi-shop', [PosController::class, 'multiShop'])->name('multi-shop');
    Route::get('/sale', [PosController::class, 'sale'])->name('sale');
    Route::post('/quick-add-product', [PosController::class, 'quickAddProduct'])->name('quick-add-product');
    Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
    Route::get('/receipt/{sale}', [PosController::class, 'receipt'])->name('receipt');
    Route::get('/daily-report', [PosController::class, 'dailyReport'])->name('daily-report');
    Route::get('/history', [PosController::class, 'history'])->name('history');

    // Multi-Shop Routes
    Route::get('/shops', [PosController::class, 'shops'])->name('shops');
    Route::get('/shops/create', [PosController::class, 'createShop'])->name('shops.create');
    Route::post('/shops', [PosController::class, 'storeShop'])->name('shops.store');
    Route::get('/shops/{shop}', [PosController::class, 'shopDashboard'])->name('shops.dashboard');
    Route::get('/shops/{shop}/sale', [PosController::class, 'shopSale'])->name('shops.sale');
    Route::post('/shops/{shop}/checkout', [PosController::class, 'shopCheckout'])->name('shops.checkout');
    Route::get('/shops/{shop}/reports', [PosController::class, 'shopReports'])->name('shops.reports');
    Route::get('/shops/{shop}/staff', [PosController::class, 'shopStaff'])->name('shops.staff');
    Route::post('/shops/{shop}/staff', [PosController::class, 'storeStaff'])->name('shops.staff.store');
    Route::delete('/shops/{shop}/staff/{user}', [PosController::class, 'removeStaff'])->name('shops.staff.remove');
    Route::post('/shops/{shop}/quick-add-product', [PosController::class, 'quickAddProductToShop'])->name('shops.quick-add-product');
    Route::get('/transfers', [PosController::class, 'transferStock'])->name('transfers');
    Route::post('/transfers', [PosController::class, 'storeTransfer'])->name('transfers.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload-image');

    /*
    |--------------------------------------------------------------------------
    | Smart Dashboard Redirect
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match (true) {
            $user->user_type === 'store_owner' || $user->store => redirect()->route('store-owner.dashboard'),
            $user->isProfessional() => redirect()->route('professional.dashboard'),
            $user->user_type === 'admin' => redirect()->route('admin.dashboard'),
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
        Route::get('/bids', [ClientDashboardController::class, 'bids'])->name('bids');
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

    // 🔹 Store Owner Dashboard
Route::middleware(['auth', 'store_owner'])->prefix('store-owner')->name('store-owner.')->group(function () {
        Route::get('/dashboard', [StoreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [StoreDashboardController::class, 'myOrders'])->name('orders');
        Route::get('/profile', [StoreDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile', [StoreDashboardController::class, 'updateProfile'])->name('profile.update');
        
        // Product Management
        Route::get('/products', [StoreDashboardController::class, 'products'])->name('products');
        Route::get('/products/create', [StoreDashboardController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [StoreDashboardController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [StoreDashboardController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{id}', [StoreDashboardController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [StoreDashboardController::class, 'deleteProduct'])->name('products.delete');
        
        // Driver Management
        Route::get('/drivers', [DriverController::class, 'index'])->name('drivers');
        Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create');
        Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
        Route::patch('/drivers/{driver}/toggle', [DriverController::class, 'toggleAvailability'])->name('drivers.toggle');
        Route::post('/drivers/nearby', [DriverController::class, 'nearby'])->name('drivers.nearby');
    });

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

    // Payment routes
    Route::middleware(['auth'])->prefix('payment')->name('payment.')->group(function () {
        Route::get('/connection/{job}', [PaymentController::class, 'showConnectionPayment'])->name('connection');
        Route::post('/connection/{job}', [PaymentController::class, 'processConnectionPayment'])->name('process-connection');
        Route::get('/professional-unlock/{professional}', [PaymentController::class, 'showProfessionalUnlock'])->name('professional-unlock');
        Route::post('/professional-unlock/{professional}', [PaymentController::class, 'processProfessionalUnlock'])->name('process-professional-unlock');
        Route::post('/escrow/{job}', [PaymentController::class, 'createEscrow'])->name('create-escrow');
        Route::post('/escrow/{escrow}/release', [PaymentController::class, 'releaseEscrow'])->name('release-escrow');
        Route::post('/escrow/{escrow}/dispute', [PaymentController::class, 'disputeEscrow'])->name('dispute-escrow');
        Route::get('/wallet/add', [PaymentController::class, 'showAddFunds'])->name('add-funds');
        Route::post('/wallet/add', [PaymentController::class, 'addFunds']);
    });

/*
|--------------------------------------------------------------------------
| Professionals
|--------------------------------------------------------------------------
*/
Route::resource('professionals', ProfessionalController::class)->except(['index']);

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
Route::prefix('messages')->name('messages.')->middleware('auth')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/start/{job}', [MessageController::class, 'start'])->name('start-job');
        Route::get('/start/professional/{professional}', [MessageController::class, 'startWithProfessional'])->name('start-professional');
        Route::get('/start-store/{store}', [MessageController::class, 'startStoreConversation'])->name('start-store');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [MessageController::class, 'send'])->name('send');
        Route::get('/{conversation}/check-new', [MessageController::class, 'checkNewMessages'])->name('check-new');
    });

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */
    Route::resource('reviews', ReviewController::class)->except(['index', 'create']);
Route::post('/reviews/{job}', [ReviewController::class, 'store'])->name('reviews.job.store');
    Route::post('/reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');
});

// Service Ecosystem Routes
Route::get('/ecosystem/stage/{stage}', [ServiceEcosystemController::class, 'getProfessionalsByStage'])->name('ecosystem.stage');
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

