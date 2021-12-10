<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::prefix('provider')->group(function () {
        Route::post('/register', [App\Http\Controllers\ServiceUserApiController::class, 'register']);
        Route::post('/deregister', [App\Http\Controllers\ServiceUserApiController::class, 'deregister']);

        Route::post('/subscribe', [App\Http\Controllers\SubscribeApiController::class, 'subscribeService']);
        Route::post('/unsubscribe', [App\Http\Controllers\SubscribeApiController::class, 'unsubscribeService']);
    });

    Route::prefix('subscriber')->group(function () {
        Route::post('/register', [App\Http\Controllers\SubscribeApiController::class, 'register']);
        Route::post('/deregister', [App\Http\Controllers\SubscribeApiController::class, 'deregister']);
    });

    Route::prefix('service')->group(function () {
        Route::post('/book', [App\Http\Controllers\BookServiceApiController::class, 'book']);

        Route::get('/{service}', [App\Http\Controllers\ServiceApiController::class, 'show']);
        Route::get('/', [App\Http\Controllers\ServiceApiController::class, 'index']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/logout', [AuthApiController::class, 'logout']);
        
        Route::get('/', function (Request $request) {
            return [ 'data' => $request->user()];
        });
        Route::prefix('jobs')->group(function () {
            Route::get('/', [App\Http\Controllers\UserServiceApiController::class, 'index']);
            Route::get('/{id}', [App\Http\Controllers\UserServiceApiController::class, 'show']);
        });
        Route::prefix('orders')->group(function () {
            Route::get('/', [App\Http\Controllers\UserServiceApiController::class, 'orders']);
        });
    });
});
