<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/** CRUD  ROUTES*/

/*  Trashed  Posts*/
Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');

/*  Restore Trashed Posts*/
Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

/*  Delete the record permanently*/
Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');

Route::resource('/posts', PostController::class);

Route::get('user-data', function (){
    return auth()->user();
});
