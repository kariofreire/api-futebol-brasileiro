<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        "status"  => true,
        "message" => env("APP_NAME"),
        "data"    => []
    ], 200);
});

Route::fallback(function () {
    return response()->json([
        "status"  => false,
        "message" => env("APP_NAME"),
        "data"    => "Página não encontrada."
    ], 404);
});
