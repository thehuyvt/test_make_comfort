<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\AuthCustomerController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Middleware\LoginAdminMiddleware;
use App\Http\Middleware\LoginCustomerMiddleware;
use App\Http\Middleware\RevalidateBackHistory;
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

Route::middleware([LoginAdminMiddleware::class, RevalidateBackHistory::class])->group(function (){
    Route::get('dashboard', [AuthAdminController::class, 'dashboard'])->name('dashboard');

    Route::get('logout-admin', [AuthAdminController::class, 'logout'])->name('admin.logout');

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
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::get('edit/{product:slug}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{product}', [ProductController::class, 'update'])->name('update');
        Route::get('search-options', [ProductController::class, 'searchOptions'])->name('search-options');
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


//Customer
Route::get('login', [AuthCustomerController::class, 'login'])->name('customers.login');
Route::post('login', [AuthCustomerController::class, 'processLogin'])->name('customers.process-login');

//Customer Middleware
Route::middleware([LoginCustomerMiddleware::class, RevalidateBackHistory::class])->group(function (){
    Route::get('profile', [AuthCustomerController::class, 'profile'])->name('customers.profile');
    Route::get('logout', [AuthCustomerController::class, 'logout'])->name('customers.logout');
    Route::get('cart', [CustomerController::class, 'cart'])->name('customers.cart');
    Route::post('add-cart/{product}', [CartController::class, 'update'])->name('carts.update');
});

//Guest
Route::get('register', [AuthCustomerController::class, 'register'])->name('customers.register');
Route::post('register', [AuthCustomerController::class, 'processRegister'])->name('customers.process-register');
Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/product/{slug}', [CustomerController::class, 'productDetail'])->name('product.detail');
