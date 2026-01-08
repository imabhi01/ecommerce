<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserAddressController;

Route::get('/test-cards', function () {
    return view('test-cards');
})->name('test-cards');

Route::get('/clear-cache', [DashboardController::class, 'clearCache'])->name('clear-cache');

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.index');

// Static Pages Contact, About, Blog etc.
Route::get('/about', [DashboardController::class, 'aboutPage'])->name('about');
Route::get('/contact', [DashboardController::class, 'contact'])->name('contact');
Route::get('/blog', [ShopController::class, 'index'])->name('blog.index');

Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('shop.category');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete']);

// Reviews
Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // E-commerce Routes copied from claude
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/stripe', [CheckoutController::class, 'processStripe'])->name('checkout.stripe');
    Route::post('/checkout/paypal', [CheckoutController::class, 'processPayPal'])->name('checkout.paypal');
    Route::get('/checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
    Route::get('/checkout/paypal/cancel', function() {
        return redirect()->route('checkout.index')->with('error', 'Payment cancelled');
    })->name('checkout.paypal.cancel');
    
    Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // End of copied routes
});

Route::middleware('auth')->group(function () {
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/{id}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [UserDashboardController::class, 'wishlist'])->name('wishlist');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [UserDashboardController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [UserDashboardController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/return', [UserDashboardController::class, 'requestReturn'])->name('orders.return');

    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Addresses
    Route::get('/addresses', [UserAddressController::class, 'index'])->name('addresses');
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::delete('products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.delete');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});


require __DIR__.'/auth.php';
