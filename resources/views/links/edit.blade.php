@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('links.update', $link) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @include('links._form')
    </form>
@endsection
