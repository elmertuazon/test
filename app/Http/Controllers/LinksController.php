<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LinksController extends Controller
{
    public function index(Request $request)
    {
        
        $links = Link::with('category', 'tags', 'author')
            ->when(auth()->check(), fn($query) => $query->withFavorited(auth()->id()))
            ->published()
            ->accepted()
            ->filter(request([
                'search',
                'popular',
                'favorite'
            ]))
            // 2021-01 $searchYear = 2021, $searchMonth = 01
            ->when($request->has('month'), fn($query) => $query->monthlyPublished(...explode('-', $request->input('month'))))
            ->latest('publish_at')
            ->paginate(config('blog.posts_per_page'))
            ->withQueryString();

        return view('links.index', compact('links'));
    }

    public function show(Link $link)
    {
        $link->load('category', 'tags', 'author', 'comments.author', 'comments.comments.author');

//        if(auth()->check()) {
//            $link->loadFavorited(auth()->id());
//        }
        $link->increment('popularity');

        return view('links.show', compact('link'));
    }

    public function create(): View
    {
        return view('links.create')
            ->with([
                'users' => User::all(),
                'categories' => Category::all(),
                'tags' => Tag::all(),
                'link' => new Link
            ]);
    }

    public function store(CreateLinkRequest $request): RedirectResponse
    {
        $link = $request->user()->links()->create($request->validated());

        //$link->tags()->sync($request->tags);

        Session::flash('success', 'Link Created!');

        return redirect()->route('links.show', $link);
    }

    public function edit(Link $link): View
    {
        return view('links.edit')
            ->with([
                'users' => User::all(),
                'categories' => Category::all(),
                'tags' => Tag::all(),
                'link' => $link
            ]);
    }

    public function update(UpdateLinkRequest $request, Link $link): RedirectResponse
    {
        $link->update($request->validated());

        //$link->tags()->sync($request->tags);

        Session::flash('success', 'Link Updated!');

        return redirect()->route('links.show', $link);
    }
}
