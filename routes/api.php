<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Global Rotalar (Sanctum authentication gerektirmez)
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


// Protected Rotalar (Sanctum authentication gerektirir)
Route::group(['middleware' => 'auth:sanctum'], function () {

    //Tüm bloglar listelenir
    Route::get('/articles', [ArticleController::class, 'index']);

    //Yeni Blog oluşturur
    Route::post('/articles/store', [ArticleController::class, 'store']);

    // Slug ile Blog verisini getirir.
    Route::get('/articles/{slug}', [ArticleController::class, 'show']);

    // Blog verisini günceller.
    Route::put('/articles/{id}', [ArticleController::class, 'update']);

    // Blog verisini siler.
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);


    // Blogları kategoriye göre filtreleme
    Route::get('/articles/category/{category_slug}', [ArticleController::class, 'category']);

    // Blog yazılarını harf veya kelime ile başlığa göre filtreleme
    Route::get('/articles/search/{search}', [ArticleController::class, 'search']);
});
