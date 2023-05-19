<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagShowController extends Controller
{
    public function __invoke(Tag $tag)
    {
        /*$posts = Post::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.id', $tag->id);
        })->paginate(config('blog.posts_per_page'));*/

        // posts -> Load a collection of posts
        // posts() -> Load a query builder for posts
        $posts = $tag->posts()->publishAt()->paginate(config('blog.posts_per_page'));

        return view('tags.index', compact('posts', 'tag'));
    }
}
