<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::group(['prefix' => 'auth'], function () {
    Route::group(['prefix' => 'register'], function () {
        Route::get('/',[AuthController::class, 'registerPage'])->name('register-page');
        Route::post('/', [AuthController::class, 'registerSubmit'])->name('register-submit');
    });
    Route::group(['prefix' => 'login'], function () {
        Route::get('/',[AuthController::class, 'loginPage'])->name('login-page');
        Route::post('/',[AuthController::class, 'loginSubmit'])->name('login-submit');
    });
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});

Route::group(['prefix' => 'short-url'], function () {
    Route::post('/',[UrlController::class, 'create'])->name('short-url')->middleware('auth');
    Route::get('/{code}',[UrlController::class, 'redirectUrl'])->name('redirect-url');
    Route::patch('/{id}',[UrlController::class,'update'])->name('short-url-update')->middleware('admin');
    Route::delete('/{id}',[UrlController::class,'delete'])->name('short-url-delete')->middleware('admin');
});

Route::group(['middleware' => ['admin'],'prefix' => 'admin'], function () {
    Route::get('/', [UserController::class, 'adminPage'])->name('admin');
});







