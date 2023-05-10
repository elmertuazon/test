<?php

namespace App\Http\Controllers;

use App\Http\Repository\post\IPostRepository;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(config('blog.posts_per_page'));

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
