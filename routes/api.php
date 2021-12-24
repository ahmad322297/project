<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
ph*/

Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class,'index']);//add filters
    Route::post('/',[ProductController::class,'store']);//store the user id without input
    Route::get('/{id}',[ProductController::class,'show']);
    Route::put('/{id}',[ProductController::class,'update']);//only update the changed data
    Route::delete('/{id}',[ProductController::class,'destroy']);//only delete if it's user's product
});

Route::prefix('categories')->group(function(){
   Route::get('/',[CategoryController::class,'index']);//add filters
   Route::post('/',[CategoryController::class,'store']);//store the user id without input
   Route::get('/{id}',[CategoryController::class,'show']);
   Route::put('/{id}',[CategoryController::class,'update']);//only update the changed data
   Route::delete('/{id}',[CategoryController::class,'destroy']);//only delete if it's user's product
});
