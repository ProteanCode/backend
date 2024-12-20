<?php

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

Route::group(['middleware' => 'auth:sanctum'], function (\Illuminate\Routing\Router $router) {
    $router->resource(
        'cards',
        \App\Http\Controllers\NftCardController::class,
        [
            'only' => ['index', 'show', 'store', 'update', 'destroy'],
        ]
    );
});
