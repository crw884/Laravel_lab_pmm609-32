<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
Route::middleware('auth:sanctum')->delete('/group/{id}', [\App\Http\Controllers\GroupControllerApi::class, 'destroy']);
Route::get('/group/{id}', [\App\Http\Controllers\GroupControllerApi::class, 'show']);
Route::middleware('auth:sanctum')->post('/group/{id}', [\App\Http\Controllers\GroupControllerApi::class, 'update']);
Route::get('/groups_total', [\App\Http\Controllers\GroupControllerApi::class, 'total']);
Route::post('/group', [\App\Http\Controllers\GroupControllerApi::class, 'store']);

Route::get('/comment', [\App\Http\Controllers\CommentControllerApi::class, 'index']);
Route::get('/comment/{id}', [\App\Http\Controllers\CommentControllerApi::class, 'show']);

Route::get('/post', [\App\Http\Controllers\PostControllerApi::class, 'index']);
Route::get('/post/{id}', [\App\Http\Controllers\PostControllerApi::class, 'show']);
Route::get('/posts_total', [\App\Http\Controllers\PostControllerApi::class, 'total']);
Route::post('/post', [\App\Http\Controllers\PostControllerApi::class, 'store']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

//Route::middleware('auth:sanctum')->get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::middleware('auth:sanctum')->get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
Route::get('/group/{id}/subscribers', [\App\Http\Controllers\GroupControllerApi::class, 'subscribers']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/group{id}/subscribe', [\App\Http\Controllers\GroupControllerApi::class, 'subscribe']);
    Route::get('/group{id}/unsubscribe', [\App\Http\Controllers\GroupControllerApi::class, 'unsubscribe']);
});

Route::get('/users', [\App\Http\Controllers\UserControllerApi::class, 'index']);
Route::get('/users_total', [\App\Http\Controllers\UserControllerApi::class, 'total']);
