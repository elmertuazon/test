<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function store(Post $post, StoreCommentRequest $request)
    {
        $post->comments()->create([
            'user_id' => request()->user()->id,
            'body' => $request->validated()['body']
        ]);

        return back();
    }
}
