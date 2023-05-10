<?php

namespace App\Http\Repository\post;

use App\Models\Post;

class PostRepository implements IPostRepository
{
    public function findAll()
    {
        // echo json_encode(Post::with('category', 'tags')->where('id', 1)->get());
        // die();
        return Post::with('category', 'tags')->paginate(10);
    }
}