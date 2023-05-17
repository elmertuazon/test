<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostsController::class, 'index'])->name('home');
Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
Route::get('/categories/{slug}', [PostsController::class, 'categoryPosts'])->name('category.show');
Route::get('/tags/{slug}', [PostsController::class, 'tagPosts'])->name('category.show');