<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)->prefix('product')->group(function(){
    Route::get('productForm','productForm')->name('productForm');
    Route::post('create','create')->name('create');
    Route::get('show','show')->name('show');
    Route::post('delete/{id}','delete')->name('delete');
    Route::get('updateForm/{id}','updateForm')->name('updateForm');
    Route::post('update/{id}','update')->name('update');
});
