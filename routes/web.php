<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Api\OrderController;
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

Route::redirect('/', '/admin');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['guest:web']
], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'do_login'])->name('do_login');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth:web']
], function () {
    Route::get('/', [OrderController::class, 'index'])->name('home');
    Route::get('/notifications', [OrderController::class, 'index'])->name('notifications');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
