@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-12 mb-4">
                        @include('posts._item', ['showBody' => false])
                    </div>
                @endforeach
            </div>

            {{ $posts->links() }}
        </div>
        <div class="col-3">
            @include('layouts._sidebar')
        </div>
    </div>
@endsection
