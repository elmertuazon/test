<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagShowController;
use App\Http\Controllers\UserPostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostsController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');

    Route::get('/my-posts', UserPostController::class)->name('user.posts');
});


Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
// index
// show
// create
// store
// edit
// update
// destroy
Route::get('/categories/{category:slug}', CategoryShowController::class)->name('category.show');

Route::get('/tags/{tag:slug}', TagShowController::class)->name('tag.show');

Auth::routes();
