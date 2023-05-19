<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryShowController extends Controller
{
    public function __invoke(Category $category)
    {
        $posts = $category->posts()->publishAt()->paginate(config('blog.posts_per_page'));
        return view('category.index', compact('posts', 'category'));
    }
}
