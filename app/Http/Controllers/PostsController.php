<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\PostCreated;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view,post')->only(['show']);
        $this->middleware('can:update,post')->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $posts = Post::with('category', 'tags', 'author')
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

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        $post->load('category', 'tags', 'author', 'comments.author');

        if(auth()->check()) {
            $post->loadFavorited(auth()->id());
        }
        $post->increment('popularity');

        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        return view('posts.create')
            ->with([
                'users' => User::all(),
                'categories' => Category::all(),
                'tags' => Tag::all(),
                'post' => new Post
            ]);
    }

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $post = $request->user()->posts()->create($request->validated());

        $post->tags()->sync($request->tags);

        Session::flash('success', 'Post Created!');

        Mail::to(Admin::first()->email)->send(new PostCreated($post));

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post): View
    {
        return view('posts.edit')
            ->with([
                'users' => User::all(),
                'categories' => Category::all(),
                'tags' => Tag::all(),
                'post' => $post
            ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        $post->tags()->sync($request->tags);

        Session::flash('success', 'Post Updated!');

        return redirect()->route('posts.show', $post);
    }
}
