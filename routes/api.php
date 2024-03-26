<?php

use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
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

        Route::post('produto', [ProdutoController::class, 'create']);
        Route::put('produto/{id}', [ProdutoController::class, 'update']);
        Route::delete('produto/{id}', [ProdutoController::class, 'delete']);
    });

    Route::group(['middleware' => 'scope:admin,user'], function () {
        Route::delete('logout', [AccessTokenController::class, 'revokeAccessToken']);

        Route::get('produto', [ProdutoController::class, 'findAll']);
        Route::get('produto/{id}', [ProdutoController::class, 'findById']);

        Route::post('user/compra/{id}', [UserController::class, 'realizaCompra']);
        Route::get('user/compra', [UserController::class, 'listaCompras']);
        Route::get('user/compra/{id}', [UserController::class, 'listaCompra']);
    });
});
