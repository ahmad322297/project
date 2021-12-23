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

Route::prefix('product')->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('/',[ProductController::class,'store']);//store the user id without input
    Route::get('/{id}',[ProductController::class,'show']);
    Route::post('/{id}',[ProductController::class,'update']);//only update the changed data
    Route::delete('/{id}',[ProductController::class,'destroy']);//not completed
});

Route::prefix('category')->group(function(){
   Route::get('/',[CategoryController::class,'index']);
   Route::post('/',[CategoryController::class,'store']);//store the user id without input
   Route::get('/{id}',[CategoryController::class,'show']);
   Route::post('/{id}',[CategoryController::class,'update']);
   Route::delete('/{id}',[CategoryController::class,'destroy']);//not completed
});
