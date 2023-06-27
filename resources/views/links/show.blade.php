@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                <div class="col-12 mb-2">
                    <a href="{{ route('home') }}">&lAarr; Back to all links</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('links._item', ['showBody' => true])

                    <div class="card">
                        <div class="card-body">
                            @auth
                                <form method="POST" action="{{ route('user.links.comments', $link) }}">
                                    @csrf
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <img src="https://i.pravatar.cc/60?={{auth()->id()}}" alt="" width="40"
                                             height="40" class="rounded-full">
                                        <h2 class="ml-4">Want to participate</h2>
                                    </div>

                                    <div class="mt-6">
                                        <textarea name="body" class="form-control rounded-0" rows="5"
                                                  placeholder="Say hello..."
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
                    @foreach ($link->comments as $comment)
                        @include('comments.index')
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3">
            @include('layouts._sidebar')
        </div>
@endsection
