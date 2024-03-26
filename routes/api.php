<?php

use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AccessTokenController::class, 'generateAccessToken']);
Route::post('user', [UserController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::group(['middleware' => 'scope:admin'], function () {
        Route::put('user/{id}', [UserController::class, 'promoteToAdmin']);
    });

    Route::group(['middleware' => 'scope:admin,user'], function () {
        Route::delete('logout', [AccessTokenController::class, 'revokeAccessToken']);
    });
});
