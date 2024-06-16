<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\AuthCustomerController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderCustomerController;
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

    Route::group(['prefix' => 'orders', 'as'=>'orders.'], function (){
        Route::get('', [OrderController::class, 'index'])->name('index');
        Route::get('show/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('edit/{order}', [OrderController::class, 'edit'])->name('edit');
        Route::put('update/{order}', [OrderController::class, 'update'])->name('update');
        Route::get('get-orders/{status}', [OrderController::class, 'getOrdersByStatus'])->name('get-orders-by-status');
        Route::post('process-order/{order}', [OrderController::class, 'updateStatus'])->name('process-order');
    });

    Route::group(['prefix' => 'statistical', 'as'=>'statistical.'], function (){
        Route::get('/', [StatisticalController::class, 'getData'])->name('data');
        Route::get('/get-order-chart', [StatisticalController::class, 'getDataOrderChart'])->name('order-chart');
        Route::get('/get-top-products-sell', [StatisticalController::class, 'getTopProductSell'])->name('top-product-sell');
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
    Route::get('profile', [AuthCustomerController::class, 'editProfile'])->name('customers.profile');
    Route::get('profile', [AuthCustomerController::class, 'editProfile'])->name('customers.profile');
    Route::put('update-customer-profile/{customer}', [AuthCustomerController::class, 'updateProfile'])->name('customers.update-profile');

    Route::get('cart', [CartController::class, 'index'])->name('carts.index');
    Route::post('add-cart/{product}', [CartController::class, 'addProductToCart'])->name('carts.add-product-to-cart');
    Route::post('update-cart/{orderCartId}', [CartController::class, 'updateCart'])->name('carts.update-product');
    Route::post('remove-product/{orderCartId}', [CartController::class, 'removeProduct'])->name('carts.remove-product');
    Route::get('sum-products-in-cart', [CartController::class, 'sumProductsInCart'])->name('carts.sum-products-in-cart');
    Route::post('check-out/{order}', [CartController::class, 'checkOut'])->name('carts.check-out');
    Route::get('list-products-in-cart', [CartController::class, 'listProductsInCart'])->name('carts.list-products-in-cart');

    Route::get('shopping-history', [OrderCustomerController::class, 'history'])->name('orders.history');
    Route::get('order-detail/{orderId}', [OrderCustomerController::class, 'detail'])->name('orders.detail');
    Route::get('order-cancel/{orderId}', [OrderCustomerController::class, 'cancel'])->name('orders.cancel');
});

//Guest
Route::get('register', [AuthCustomerController::class, 'register'])->name('customers.register');
Route::post('register', [AuthCustomerController::class, 'processRegister'])->name('customers.process-register');
Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/product/{slug}', [CustomerController::class, 'productDetail'])->name('product.detail');
Route::get('/all-products', [CustomerController::class, 'allProducts'])->name('customers.all-product');
Route::get('/list-products', [CustomerController::class, 'listProducts'])->name('customers.list-products');
