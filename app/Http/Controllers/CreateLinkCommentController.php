<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Link;
use App\Models\Post;
use Illuminate\Http\Request;

class CreateLinkCommentController extends Controller
{
    public function __invoke(Link $link, StoreCommentRequest $request)
    {
        $link->comments()->create([
            'user_id' => request()->user()->id,
            'body' => $request->validated()['body']
        ]);

        return back();
    }
}
