<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class CreateLinkFavoriteController extends Controller
{
    public function __invoke(Link $link, Request $request)
    {
        $existingFavorite = $link
        ->favorites()
        ->where('user_id', $request->user()->id)
        ->first();
        if($existingFavorite) {
            $link->favorites()->delete();
        } else {
            $link->favorites()->create(['user_id'=>$request->user()->id]);
        }

        return back();
    }
}
