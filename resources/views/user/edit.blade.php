@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @include('user._form')
    </form>
@endsection
