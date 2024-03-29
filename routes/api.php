<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\Cart2Controller;
use App\Http\Controllers\Customer\OrderController;
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
Route::post('/login/{type}', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signup-for-admin', [AuthController::class, 'signupForAdmin']);
Route::middleware(['auth:sanctum', 'ability:customer,admin'])->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout']);
});


Route::get('/product/get-quantity/{id}', [ProductController::class, 'getQuantity']);
Route::get('/product/search', [ProductController::class, 'search']);
Route::get('/product/get-detail/{id}', [ProductController::class, 'getProduct']);
Route::get('/product/get-by-subcategory/{subcategory_id}/{product_id}', [ProductController::class, 'getProductsBySubcategory']);

Route::get('/category/get-all', [CategoryController::class, 'getCategories']);

Route::put('/cart/chose-all', [CartController::class, 'choseAll']);
Route::put('/cart/chose', [CartController::class, 'chose']);
Route::resources([
    'cart' => CartController::class,
]);

Route::post('/cart2/get-all', [Cart2Controller::class, 'index2']);
Route::put('/cart2/chose-all', [Cart2Controller::class, 'choseAll']);
Route::put('/cart2/chose', [Cart2Controller::class, 'chose']);
Route::resources([
    'cart2' => Cart2Controller::class,
]);

Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });

        Route::post('/file', [FileController::class, 'addFiles']);
        Route::post('/file/delete', [FileController::class, 'deleteFiles']);

        Route::post('/product/deleteMulti', [ProductManagementController::class, 'deleteMulti']);

        Route::resources([
            'product' => ProductManagementController::class,
            'order' => OrderManagementController::class,
        ]);

        Route::get('/statistic/order-state', [StatisticController::class, 'orderStateStatistics']);
        Route::get('/statistic/revenue/{year}/{month}', [StatisticController::class, 'revenueStatistics']);
    });
});

Route::middleware(['auth:sanctum', 'ability:customer'])->group(function () {
    Route::get('/customer', function (Request $request) {
        return $request->user();
    });
    Route::post('/order2', [OrderController::class, 'store2']);
    Route::resources([
        'order' => OrderController::class,
    ]);
});
