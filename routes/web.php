<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CreateCommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagShowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// index
// show
// create
// store
// edit
// update
// destroy

Route::get('/', [PostsController::class, 'index'])->name('home');


Route::get('/categories/{category:slug}', CategoryShowController::class)->name('category.show');
Route::get('/tags/{tag:slug}', TagShowController::class)->name('tag.show');

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostsController::class)->except(['index', 'destroy']);
    Route::post('posts/{post}/comments', CreateCommentController::class)->name('user.posts.comments');
    Route::post('posts/{post}/favorite', FavoriteController::class)->name('user.posts.favorite');

    Route::get('/my-posts', UserPostController::class)->name('user.posts');

    Route::get('account', [UserController::class, 'edit'])->name('user.edit');
    Route::put('account', [UserController::class, 'update'])->name('user.update');
    Route::put('account/password', [UserController::class, 'updatePassword'])->name('user.update-password');
});

Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');

Auth::routes();
