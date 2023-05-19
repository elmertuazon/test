<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagShowController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostsController::class, 'index'])->name('home');
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
