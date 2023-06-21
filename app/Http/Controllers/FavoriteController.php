<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __invoke(Request $request, Post $post): RedirectResponse
    {
        $existingFavorite = $request->user()
            ->favorites()
            ->where('post_id', $post->id)
            ->first();

        if($existingFavorite) {
            $existingFavorite->delete();
        } else {
            $request->user()->favorites()->create([
                'post_id' => $post->id
            ]);
        }

        return back();
    }
}
