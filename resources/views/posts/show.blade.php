@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-2">
            <a href="{{ route('home') }}">&lAarr; Back to all posts</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('posts._item')
        </div>
    </div>
@endsection
