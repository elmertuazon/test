<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\PostCreated;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('category', 'tags', 'favorites', 'author')
            ->published()
            ->accepted()
            ->filter(request([
                'search',
                'popular',
                'favorite'
            ]))
            ->monthlyPublished($request)
            ->latest('publish_at')
            ->paginate(config('blog.posts_per_page'))
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        $this->authorize('view', $post);

        $post->load('category', 'tags', 'favorites', 'author', 'comments.author');

        $post->update([
            'popularity' => $post->popularity + 1,
        ]);
        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('users', 'categories', 'tags'))->with('post', new Post());
    }

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $post = Post::create($request->validated());

        $post->tags()->sync($request->tags);

        Session::flash('success', 'Post Created!');

        Mail::to(Admin::first()->email)->send(new PostCreated($post));

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'users', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        $post->tags()->sync($request->tags);

        Session::flash('success', 'Post Updated!');

        return redirect()->route('posts.show', $post);
    }

    public function isFavorite(Request $request, Post $post): RedirectResponse
    {
        $favorite_result = 0;
        switch ($request->is_favorite) {
            case 0:
                $favorite_result = 1;
                break;

            case 1:
                $favorite_result = 0;
                break;
        }
        Favorite::updateOrCreate([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id
        ],[
            'is_favorite' =>  $favorite_result
        ]);

        return back();
    }
}
