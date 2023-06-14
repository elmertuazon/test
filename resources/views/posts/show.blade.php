@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                <div class="col-12 mb-2">
                    <a href="{{ route('home') }}">&lAarr; Back to all posts</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('posts._item', ['showBody' => true])

                    <div class="card">
                        <div class="card-body">
                            @auth
                                <form method="POST" action="/posts/{{$post->slug}}/comments">
                                    @csrf

                                    <header class="flex">
                                        <img src="https://i.pravatar.cc/60?={{auth()->id()}}" alt="" width="40"
                                             height="40" class="rounded-full">
                                        <h2 clss="ml-4">Want to participate</h2>
                                    </header>

                                    <div class="mt-6">
                                        <textarea name="body" class="form-control rounded-0" rows="5" placeholder="Hey"
                                                  required></textarea>
                                    </div>

                                    @error('body')
                                    <span class="text-xs text-red-500">{{$message}}</span>
                                    @enderror

                                    <div class="flex mt-6">
                                        <button type="submit"
                                                class="btn btn-primary">
                                            Post
                                        </button>
                                    </div>
                                </form>

                            @else
                                <p class="font-semibold">
                                    <a href="/register" class="hover:underline">Register</a> or <a href="/login"
                                                                                                   class="hover:underline">log
                                        in</a> to leave a message
                                </p>
                            @endauth
                        </div>
                    </div>
                    @foreach ($post->comments as $comment)
                        @include('comments.index')
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3">
            @include('layouts._sidebar')
        </div>
@endsection
