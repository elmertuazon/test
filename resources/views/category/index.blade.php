@extends('layouts.blog_app')

@section('content')
    
    <div class="row">
        <div>
            <div class="col-12 mb-4">
                    <h2>{{ucfirst($category->name)}}</h2>
                    <h6>Total: {{$posts->total()}}</h6>
            </div>
        </div>
        @foreach ($posts as $post)
            <div class="col-12 mb-4">
                @include('posts._item')
            </div>
        @endforeach
    </div>

    {{ $posts->links() }}
@endsection
