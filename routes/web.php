<?php

use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginAdminMiddleware;
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

Route::middleware([LoginAdminMiddleware::class])->group(function (){
    Route::get('dashboard', [AuthAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

    Route::group(['prefix' => 'categories', 'as'=>'categories.'], function (){
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{categoryId}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('update/{categoryId}', [CategoryController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'products', 'as'=>'products.'], function (){
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('api', [ProductController::class, 'api'])->name('api');
        Route::get('show/{productId}', [ProductController::class, 'show'])->name('show');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{productId}', [ProductController::class, 'edit'])->name('edit');
        Route::put('update/{productId}', [ProductController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'users', 'as'=>'users.'], function (){
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{userId}', [UserController::class, 'edit'])->name('edit');
        Route::put('update/{userId}', [UserController::class, 'update'])->name('update');
        Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
        Route::put('update-password', [UserController::class, 'updatePassword'])->name('update-password');
    });
});

Route::get('login-admin', [AuthAdminController::class, 'login'])->name('admin.login');
Route::post('login-admin', [AuthAdminController::class, 'processLogin'])->name('admin.process-login');



//Customer interface

Route::get('', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/product/{slug}', [CustomerController::class, 'productDetail'])->name('product.detail');
