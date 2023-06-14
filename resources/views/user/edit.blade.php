@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('user.update') }}">
        @method('PUT')
        @csrf

        @include('user._account_information')
    </form>

    <div class="mb-4"></div>

    <form method="POST" action="{{ route('user.update-password') }}">
        @method('PUT')
        @csrf

        @include('user._account_password')
    </form>

@endsection
