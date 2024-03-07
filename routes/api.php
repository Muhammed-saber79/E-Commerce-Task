<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
    'middleware' => ['guest:api']
], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group([
        'prefix' => 'products',
    ], function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });

    Route::group([
        'prefix' => 'cart',
    ], function () {
        Route::post('/add_product', [CartController::class, 'add_product_to_cart']);
        Route::delete('/remove_product', [CartController::class, 'remove_product_from_cart']);
        Route::put('/increase_quantity', [CartController::class, 'increase_quantity']);
        Route::put('/decrease_quantity', [CartController::class, 'decrease_quantity']);
        Route::get('/{cart}/cart_items', [CartController::class, 'cart_items']);
    });

    Route::group([
        'prefix' => 'order',
    ], function () {
        Route::post('/create', [OrderController::class, 'store']);
    });
});
