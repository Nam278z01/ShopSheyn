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

// Route::get('/product', function () {
//     return view('customer.product');
// });

// Route::get('/details', function () {
//     return view('customer.details');
// });

// Route::get('/cart', function () {
//     return view('customer.cart');
// });
