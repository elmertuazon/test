@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-12 mb-4">
                @include('post._item')
            </div>
        @endforeach
    </div>

    {{ $posts->links() }}
@endsection
