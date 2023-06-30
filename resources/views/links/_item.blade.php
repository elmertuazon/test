<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('links.show', $link )}}"><h2>{{$link->title}}</h2></a>
            <h6 style="color:red">{{ucfirst($link->status)}}</h6>
            @if($link->publish_at)
                <h6>{{ $link->publish_at->format('d/m/Y \a\t H:i')}}</h6>
            @endif

        </div>
        <h6>By {{$link->author->name}}</h6>
    </div>
    <div class="card-body">
        <h4 class="mt-4"><em>Introduction {{$link->introduction}}</em></h4>

        @if($showBody)
            <div class="mt-4">
                <a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Categorised as <a
                    href="{{ route('category.show', $link->category) }}"><strong>{{$link->category->name}}</strong></a>
            </h6>
            @can('update', $link)
                <a href="{{ route('links.edit', $link) }}">Edit</a>
            @endcan
            @auth
                <h6>
                    <div>
                        @include('links._favorite')
                    </div>
                </h6>
            @endauth
            <h6>Tags {!! $link->tagsAsLinks() !!}</h6>
        </div>
    </div>
</div>
