<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/hello", function () {
    return view('hello', ['title' => 'Hello world! o_0']);
});

Route::get("/group", [GroupController::class, 'index']);
Route::get("/group/{id}", [GroupController::class, 'show'])->name('group');

Route::get("/user", [UserController::class, 'index']);
Route::get("/user/{id}", [UserController::class, 'show'])->name('user');

Route::get("/post", [PostController::class, 'index']);
Route::get("/post/{id}", [PostController::class, 'show'])->name('post');

// Маршруты для обложек и треков
Route::get('/post/{id}/image', [PostController::class, 'getImage'])->name('post.image');
Route::get('/post/{id}/audio', [PostController::class, 'getAudio'])->name('post.audio');

