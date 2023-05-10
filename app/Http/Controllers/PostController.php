<?php

namespace App\Http\Controllers;

use App\Http\Repository\post\IPostRepository;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(IPostRepository $repository)
    {
        $data = $repository->findAll();
        return view('post.index', ['data'=>$data]);
    }

    public function show(Post $post)
    {
        return view('post.show', ['data'=>$post]);
    }
}
