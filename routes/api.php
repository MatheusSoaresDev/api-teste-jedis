<?php

use App\Http\Controllers\AccessTokenController;
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

Route::post('oauth/token', AccessTokenController::class);

Route::middleware('auth:api')->group(function () {
    Route::get('user', function (Request $request) {
        dd($request->user());
    })->middleware(['scope:admin']);

    Route::get('listar/produtos', function (Request $request) {
        dd('Listar produtos');
    })->middleware(['scope:admin,user']);
});
