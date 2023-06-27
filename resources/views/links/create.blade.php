@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('links.store') }}" enctype="multipart/form-data">
        @csrf
        @include('links._form')
    </form>
@endsection
