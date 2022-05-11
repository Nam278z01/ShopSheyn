<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('customer.index');
});

Route::get('/product', function () {
    return view('customer.index');
});

Route::get('/details', function () {
    return view('customer.index');
});

Route::get('/cart', function () {
    return view('customer.index');
});

Route::get('/orders', function () {
    return view('customer.index');
});

Route::get('/orderdetails', function () {
    return view('customer.index');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('/login', function () {
        return view('admin.login');
    });

    Route::get('/product', function () {
        return view('admin.product');
    });

    Route::get('/order', function () {
        return view('admin.order');
    });
});
