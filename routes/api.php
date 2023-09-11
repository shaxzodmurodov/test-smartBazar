<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
});

Route::group([
    'as' => 'api.',
    'middleware' => 'auth:api'
],function () {
    Route::group([
        'prefix' => 'merchants'
    ], function () {
        Route::controller(MerchantController::class)->group(function () {
            Route::post('/index', 'index')->name('merchant.index');
            Route::get('/{id}', 'show')->name('merchant.show');
            Route::post('/create', 'store')->name('merchant.store');
            Route::post('/delete', 'destroy')->name('merchant.destroy');
        });
    });
    Route::group([
        'prefix' => 'shops'
    ], function () {
        Route::controller(ShopController::class)->group(function () {
            Route::post('/index', 'index')->name('shops.index');
            Route::get('/{id}', 'show')->name('shops.show');
            Route::post('/create', 'store')->name('shops.store');
            Route::post('/delete', 'destroy')->name('shops.destroy');
        });
    });
});
