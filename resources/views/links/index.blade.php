@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                @foreach ($links as $link)
                    <div class="col-12 mb-4">
                        @include('links._item', ['showBody' => false])
                    </div>
                @endforeach
            </div>

            {{ $links->links() }}
        </div>
        <div class="col-3">
            @include('layouts._sidebar')
        </div>
    </div>
@endsection
