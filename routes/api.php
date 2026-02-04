<?php



Route::get('/group', [\App\Http\Controllers\GroupControllerApi::class, 'index']);
Route::get('/group/{id}', [\App\Http\Controllers\GroupControllerApi::class, 'show']);

Route::get('/comment', [\App\Http\Controllers\CommentControllerApi::class, 'index']);
Route::get('/comment/{id}', [\App\Http\Controllers\CommentControllerApi::class, 'show']);

Route::get('/post', [\App\Http\Controllers\PostControllerApi::class, 'index']);
Route::get('/post/{id}', [\App\Http\Controllers\PostControllerApi::class, 'show']);
