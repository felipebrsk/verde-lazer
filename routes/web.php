<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
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

// Users section
Route::prefix('/user')->group(function(){
    Route::view('/login', 'frontend.pages.login')->name('login.form');
    Route::view('/register', 'frontend.pages.register')->name('register.form');

    Route::post('/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
    Route::post('/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');
});

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
});