<?php

use App\Http\Controllers\GroupController;
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

Route::get("/group", [GroupController::class, 'index'])->name('group.index');
Route::get("/group/create", [GroupController::class, 'create'])->name('group.create');
Route::post("/group", [GroupController::class, 'store'])->name('group.store');
Route::get("/group/{id}/edit", [GroupController::class, 'edit'])->name('group.edit');
Route::put("/group/{id}", [GroupController::class, 'update'])->name('group.update');
Route::delete("/group/{id}", [GroupController::class, 'destroy'])->name('group.destroy');
Route::get("/group/{id}", [GroupController::class, 'show'])->name('group.show');

Route::get("/user", [UserController::class, 'index'])->name('user.index');
Route::get("/user/{id}", [UserController::class, 'show'])->name('user.show');

Route::get("/posts", [PostController::class, 'index'])->name('post.index');
Route::get('/group/{group_id}/createpost', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::get("/post/{id}/edit", [PostController::class, 'edit'])->name('post.edit');
Route::put("/post/{id}", [PostController::class, 'update'])->name('post.update');
Route::delete("/post/{id}", [PostController::class, 'destroy'])->name('post.destroy');
Route::get("/post/{id}", [PostController::class, 'show'])->name('post.show');
// Маршруты для обложек и треков
Route::get('/post/{id}/image', [PostController::class, 'getImage'])->name('post.image');
Route::get('/post/{id}/audio', [PostController::class, 'getAudio'])->name('post.audio');



