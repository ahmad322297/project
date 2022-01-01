<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
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

Route::prefix('products')->middleware(['auth:api'])->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('/',[ProductController::class,'store']);
    Route::get('/{id}',[ProductController::class,'show']);
    Route::put('/{id}',[ProductController::class,'update']);
    Route::delete('/{id}',[ProductController::class,'destroy']);

    Route::prefix('{product}/comments')->group(function(){
        Route::get('/',[CommentController::class,'index']);
        Route::post('/',[CommentController::class,'store']);
        Route::put('/{comment_id}',[CommentController::class,'update']);
        Route::delete('/{comment_id}',[CommentController::class,'destroy']);
    });

    Route::prefix('{product}/likes')->group(function(){
        Route::get('/',[LikeController::class,'index']);
        Route::post('/',[LikeController::class,'store']);
    });
});

Route::prefix('categories')->middleware(['auth:api'])->group(function(){
   Route::get('/',[CategoryController::class,'index']);
   Route::post('/',[CategoryController::class,'store']);
   Route::get('/{id}',[CategoryController::class,'show']);
   Route::put('/{id}',[CategoryController::class,'update']);
   Route::delete('/{id}',[CategoryController::class,'destroy']);
});

Route::prefix('auth')->group(function(){
    Route::post('/signup', [AuthController::class,'signup']);
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/logout', [AuthController::class,'logout'])->middleware(['auth:api']);
});
