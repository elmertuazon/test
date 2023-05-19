<?php

namespace App\Http\Controllers;

use App\Http\Repository\post\IPostRepository;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'tags')->published()->paginate(config('blog.posts_per_page'));

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_if($post->publish_at > now(), 404);
        return view('posts.show', compact('post'));
    }
}
