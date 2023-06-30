<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __invoke(Request $request, Post $post): RedirectResponse
    {
        $existingFavorite = $post
            ->favorites()
            ->where('user_id', $request->user()->id)
            ->first();
        if($existingFavorite) {
            $existingFavorite->delete();
        } else {
            $post->favorites()->create(['user_id'=>$request->user()->id]);
        }

        return back();
    }
}

        // $link = Link::create([
        //     'title' => 'sample',
        //     'introduction' => 'introduction',
        //     'url' => 'url link',
        //     'category_id' => 1,
        //     'author_id'=>$request->user()->id
        // ]);
        // $link->favorites()->create(['user_id'=>$request->user()->id]);
        // $post->favorites()->create(['user_id'=>$request->user()->id]);
