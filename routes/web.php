<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShippingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);



// Frontend Routes
Route::view('about-us', 'frontend.pages.about-us')->name('about-us');
Route::view('contact', 'frontend.pages.contact')->name('contact');

Route::get('/', [FrontendController::class, 'home'])->name('home');

Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');
Route::get('/product/category/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('/product/sub-category/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');

Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
Route::get('/product-listas', [FrontendController::class, 'productLists'])->name('product-lists');

Route::match(['get', 'post'], '/filtros', [FrontendController::class, 'productFilter'])->name('shop.filter');

Route::get('/product/details/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');



// Income section to call orders earning function
Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');



// Apply and remove a coupon to a user session
Route::post('/coupon-add', [CouponController::class, 'couponApply'])->name('coupons.apply');
Route::post('/coupon-remove', [CouponController::class, 'couponRemove'])->name('coupons.remove');



// Blog
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');


// Socialite 
Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');





// Users section
Route::prefix('/user')->group(function () {
    // Auth
    Route::view('/login', 'frontend.pages.login')->name('login.form');
    Route::view('/register', 'frontend.pages.register')->name('register.form');

    // Wishlist
    Route::view('/wishlist', 'frontend.pages.wishlist')->name('wishlist');

    Route::get('/wishlist/add/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
    Route::get('wishlist/remove/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');

    // Cart section
    Route::view('cart', 'frontend.pages.cart')->name('cart');

    Route::get('/add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart')->middleware('user');
    Route::get('carrinho/remover/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');

    Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('user');
    Route::post('cart/update', [CartController::class, 'cartUpdate'])->name('cart.update');

    // Auth
    Route::post('/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
    Route::post('/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');
});






// Admin backend section
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}/update', [AdminController::class, 'profileUpdate'])->name('profile-update');

    Route::view('/change-password', 'backend.users.changePassword')->name('change.password.form');
    Route::post('/change-password/update', [AdminController::class, 'changePassword'])->name('password-update');

    // Settings 
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

    // Message
    Route::resource('/message', MessageController::class);
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');

    // Notification 
    Route::resource('/notification', NotificationController::class);
    Route::view('/notificacoes', 'backend.notification.index')->name('all.notification');
    Route::get('/notificacao/{id}', [NotificationController::class, 'show'])->name('admin.notification');

    // Banner
    Route::resource('/banners', BannerController::class);

    // Category
    Route::resource('/categories', CategoryController::class);

    // Ajax for sub category
    Route::post('/categories/{id}/child', [CategoryController::class, 'getChildByParent']);

    // Coupon
    Route::resource('/coupons', CouponController::class);

    // Product Review
    Route::resource('/reviews', ProductReviewController::class);
    Route::post('/products/{slug}/review', [ProductReviewController::class, 'addReview'])->name('reviews.add');

    // Products
    Route::resource('/products', ProductController::class);

    // Gallery
    Route::resource('/galleries', GalleryController::class);

    // Shipping
    Route::resource('/shippings', ShippingController::class);

    // Order
    Route::resource('/orders', OrderController::class);
    Route::get('/orders/pdf/{id}', [OrderController::class, 'pdf'])->name('pdf.generate');
});
