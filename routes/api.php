<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
Route::get('/group/{id}', [\App\Http\Controllers\GroupControllerApi::class, 'show']);

Route::get('/comment', [\App\Http\Controllers\CommentControllerApi::class, 'index']);
Route::get('/comment/{id}', [\App\Http\Controllers\CommentControllerApi::class, 'show']);

Route::get('/post', [\App\Http\Controllers\PostControllerApi::class, 'index']);
Route::get('/post/{id}', [\App\Http\Controllers\PostControllerApi::class, 'show']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
