<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/customer', function (Request $request) {
        return $request->user();
    });
    Route::resources([
        'order' => OrderController::class,
    ]);
    Route::delete('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/product/search', [ProductController::class, 'search']);

Route::post('/upload/delete', [UploadController::class, 'deleteFiles']);

Route::resources([
    'category' => CategoryController::class,
    'product' => ProductController::class,
    'cart' => CartController::class,
    'upload' => UploadController::class,
]);
