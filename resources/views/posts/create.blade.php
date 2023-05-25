@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('posts._form')
    </form>
@endsection
