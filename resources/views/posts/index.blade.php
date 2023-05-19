@extends('layouts.blog_app')

@section('content')
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-12 mb-4">
                @include('posts._item')
            </div>
        @endforeach
    </div>

    {{ $posts->links() }}
@endsection
