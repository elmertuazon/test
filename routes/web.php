<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostsController::Class, 'index'])->name('home');
Route::get('/posts/{post}', [PostsController::Class, 'show'])->name('posts.show');
