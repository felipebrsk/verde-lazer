<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Full access view routes
Route::view('contato', 'frontend.pages.contact')->name('contact');

// Income section to call orders earning function
Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');

// Socialite 
Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

// Users section
Route::prefix('/user')->group(function(){
    // Auth
    Route::view('/login', 'frontend.pages.login')->name('login.form');
    Route::view('/register', 'frontend.pages.register')->name('register.form');
    
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
    
    // Message
    Route::resource('/message', MessageController::class);
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');
    
    // Notification 
    Route::resource('/notification', NotificationController::class);
    Route::view('/notificacoes', 'backend.notification.index')->name('all.notification');
    Route::get('/notificacao/{id}', [NotificationController::class, 'show'])->name('admin.notification');
});