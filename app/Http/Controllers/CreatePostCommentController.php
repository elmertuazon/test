<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatePostCommentController extends Controller
{
    public function __invoke(Post $post, StoreCommentRequest $request)
    {
        $post->comments()->create([
            'user_id' => Auth::id(), // authenticated user - not comming from request
            'body' => $request->validated()['body']
        ]);

        return back();
    }
}
