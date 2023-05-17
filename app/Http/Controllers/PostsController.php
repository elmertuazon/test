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
        $posts = Post::with('category', 'tags')->paginate(config('blog.posts_per_page'));

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function categoryPosts(string $slug)
    {
        $category = Category::where('name',$slug)->first();
        // echo json_encode($category->posts());
        // die();
        $posts = Post::where('category_id', $category->id)->paginate(config('blog.posts_per_page'));
        return view('category.index', compact('posts'));
    }

    public function tagPosts(string $slug)
    {
        $tag = Tag::where('slug',$slug)->first();
        $posts = Post::findByTagId($tag);
        return view('tags.index', compact('posts'));
    }
}
