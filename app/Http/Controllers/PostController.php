<?php

namespace App\Http\Controllers;

use App\Http\Repository\post\IPostRepository;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(config('blog.posts_per_page'));

        return view('post.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }
}
