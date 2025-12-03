<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//
Route::get('/', function () {
    return redirect()->route('post.index');
});

Route::get("/hello", function () {
    return view('hello', ['title' => 'Hello world! o_0']);
});
//

Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
});

Route::get("/group", [GroupController::class, 'index'])->name('group.index');
Route::get("/group/create", [GroupController::class, 'create'])->name('group.create')->middleware('auth');
Route::post("/group", [GroupController::class, 'store'])->name('group.store')->middleware('auth');
Route::get("/group/{id}/edit", [GroupController::class, 'edit'])->name('group.edit')->middleware('auth');
Route::put("/group/{id}", [GroupController::class, 'update'])->name('group.update')->middleware('auth');
Route::delete("/group/{id}", [GroupController::class, 'destroy'])->name('group.destroy')->middleware('auth');
Route::get("/group/{id}", [GroupController::class, 'show'])->name('group.show');

Route::get("/user", [UserController::class, 'index'])->name('user.index');
Route::get("/user/{id}", [UserController::class, 'show'])->name('user.show');

Route::post('/auth', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get("/posts", [PostController::class, 'index'])->name('post.index');
Route::get('/group/{group_id}/createpost', [PostController::class, 'create'])->name('post.create')->middleware('auth');
Route::post('/post', [PostController::class, 'store'])->name('post.store')->middleware('auth');
Route::get("/post/{id}/edit", [PostController::class, 'edit'])->name('post.edit')->middleware('auth');
Route::put("/post/{id}", [PostController::class, 'update'])->name('post.update')->middleware('auth');
Route::delete("/post/{id}", [PostController::class, 'destroy'])->name('post.destroy')->middleware('auth');
Route::get("/post/{id}", [PostController::class, 'show'])->name('post.show');
// Маршруты для обложек и треков
Route::get('/post/{id}/image', [PostController::class, 'getImage'])->name('post.image');
Route::get('/post/{id}/audio', [PostController::class, 'getAudio'])->name('post.audio');

Route::post('/post/{id}', [CommentController::class, 'store'])->name('comment.store');

Route::post('/group/{id}/subscribe', [GroupController::class, 'subscribe'])->name('group.subscribe');
Route::post('/group/{id}/unsubscribe', [GroupController::class, 'unsubscribe'])->name('group.unsubscribe');


