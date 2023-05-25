<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPostController extends Controller
{
    public function __invoke()
    {
        $posts = Post::where('author_id', auth()->user()->id)->published()->paginate(config('blog.posts_per_page'));
        return view('posts.index', compact('posts'));
    }
}
