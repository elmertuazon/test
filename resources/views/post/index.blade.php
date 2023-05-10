@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach ($data as $item)
            <div class="col-12 mb-4">
                @include('post._item', ['item' => $item])
            </div>
        @endforeach
    </div>

    {{ $data->links() }}
@endsection
