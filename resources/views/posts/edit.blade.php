@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @include('posts._form')
    </form>
@endsection
