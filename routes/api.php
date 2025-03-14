<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use anuncielo\Http\Controllers\Productos;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Product API routes with CORS middleware
Route::middleware('cors')->prefix('productos')->group(function () {
    Route::get('/', [Productos::class, 'apiGetProducts']);
    Route::get('/destacados', [Productos::class, 'apiGetFeaturedProducts']);
    Route::get('/marcas', [Productos::class, 'apiGetBrands']);
    Route::get('/{slug}', [Productos::class, 'apiGetProduct']);
});
