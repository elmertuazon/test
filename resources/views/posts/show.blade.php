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
                </div>
            </div>
        </div>
        <div class="col-3">
            @include('layouts._sidebar')
        </div>
    </div>
@endsection
