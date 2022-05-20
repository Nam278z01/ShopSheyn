<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/size/get-quantity/{id}', [SizeController::class, 'getQuantity']);
Route::post('/login/{type}', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signup-for-admin', [AuthController::class, 'signupForAdmin']);
Route::get('/product/search', [ProductController::class, 'search']);
Route::get('/product/get-detail/{id}', [ProductController::class, 'getProduct']);
Route::get('/product/get-by-subcategory/{id}', [ProductController::class, 'getProductBySubcategory']);

Route::middleware(['auth:sanctum', 'ability:customer,admin'])->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::get('/admin', function (Request $request) {
        return $request->user();
    });
    Route::post('/order/update-order-state', [OrderController::class, 'updateOrderState']);

    Route::get('/order/get-all', [OrderController::class, 'getAllOrder']);
    Route::post('/upload/delete', [UploadController::class, 'deleteFiles']);
    Route::resources([
        'upload' => UploadController::class,
        'product' => ProductController::class,
    ]);
});

Route::middleware(['auth:sanctum', 'ability:customer'])->group(function () {
    Route::get('/customer', function (Request $request) {
        return $request->user();
    });
    Route::resources([
        'order' => OrderController::class,
    ]);
});

Route::resources([
    'category' => CategoryController::class,
    'cart' => CartController::class,
]);
