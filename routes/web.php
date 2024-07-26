<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*  Trashed  Posts*/
Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');

Route::resource('posts', PostController::class);


