<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
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


Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::controller(CountryController::class)->prefix('country')->group(function(){
    Route::post('create','create');
});

Route::controller(VendorController::class)->prefix('vendor')->group(function(){
    Route::post('create','create');
});

Route::controller(OrderController::class)->prefix('order')->group(function(){
    Route::post('create','create');
    Route::get('/continent/{name}/vendor-orders', 'getVendorOrdersByContinent');

});


