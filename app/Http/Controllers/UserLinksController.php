<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Post;

class UserLinksController extends Controller
{
    public function __invoke()
    {
        $links = Link::where('author_id', auth()->id())->latest()
            ->paginate(config('blog.posts_per_page'));

        return view('links.index', compact('links'));
    }
}
