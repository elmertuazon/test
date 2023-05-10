@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('post._item', ['item' => $data])
        </div>
    </div>
@endsection
