<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Link;
use App\Models\Post;
use Illuminate\Http\Request;

class CreateCommentReplyController extends Controller
{
    public function __invoke(Comment $comment, StoreCommentRequest $request)
    {
        $comment->comments()->create([
            'user_id' => request()->user()->id,
            'body' => $request->validated()['body']
        ]);

        return back();
    }
}
