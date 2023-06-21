<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagShowController;
use App\Http\Controllers\UserController;
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

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('user.posts.comments');

    Route::post('is-favorite/{post}', [PostsController::class, 'isFavorite'])->name('favorite');

    Route::get('account', [UserController::class, 'edit'])->name('user.edit');

    Route::put('account', [UserController::class, 'update'])->name('user.update');
    Route::put('account/password', [UserController::class, 'updatePassword'])->name('user.update-password');
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
