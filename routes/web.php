<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CreateCommentReplyController;
use App\Http\Controllers\CreateLinkCommentController;
use App\Http\Controllers\CreateLinkFavoriteController;
use App\Http\Controllers\CreatePostCommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagShowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLinksController;
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
    Route::post('posts/{post}/comments', CreatePostCommentController::class)->name('user.posts.comments');
    Route::post('posts/{post}/favorite', FavoriteController::class)->name('user.posts.favorite');

    Route::get('/my-posts', UserPostController::class)->name('user.posts');


    Route::resource('links', LinksController::class)->except(['destroy']);
    Route::post('links/{link}/comments', CreateLinkCommentController::class)->name('user.links.comments');
    Route::post('links/{link}/favorite', CreateLinkFavoriteController::class)->name('user.links.favorite');
    Route::get('/my-links', UserLinksController::class)->name('user.links');

    Route::post('comments/{comment}/comments', CreateCommentReplyController::class)->name('user.comments.comments');


    Route::get('account', [UserController::class, 'edit'])->name('user.edit');
    Route::put('account', [UserController::class, 'update'])->name('user.update');
    Route::put('account/password', [UserController::class, 'updatePassword'])->name('user.update-password');
});

Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');

Auth::routes();
