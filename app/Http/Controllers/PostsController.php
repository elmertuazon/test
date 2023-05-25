<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Mail\PostCreated;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'tags')->published()->accepted()->latest()->paginate(config('blog.posts_per_page'));
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.store', compact('users', 'categories', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['image'])) {
            $path = $request->file('image')->store('images');
            $validated['image'] = substr($path, 7);
        }
        $post = Post::create($validated);

        Session::flash('success', 'Post Created!');

        Mail::to(Admin::first()->email)->send(new PostCreated($post));

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'users', 'categories', 'tags'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validated();
        if (isset($validated['image'])) {
            $path = $request->file('image')->store('images');
            $validated['image'] = substr($path, 7);
        }
        $post->update($validated);
        Session::flash('success', 'Post Updated!');

        return redirect()->route('posts.show', $post);
    }
}
