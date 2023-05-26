<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('posts.show', $post )}}"><h2>{{$post->title}}</h2></a>
            <h6 style="color:red">{{ucfirst($post->status)}}</h6>
            @if($post->publish_at)
                <h6>{{ $post->publish_at->format('d/m/Y \a\t H:i')}}</h6>
            @endif

        </div>
        <h6>By {{$post->author->name}}</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-center">
            @if ($post->image)
                <img style="max-height: 200px" src="/{{ $post->image }}"/>
            @else
                <div class="fakeimg" style="height:200px;"></div>
            @endif
        </div>

        <h4 class="mt-4"><em>Introduction {{$post->introduction}}</em></h4>

        @if($showBody)
            <div class="mt-4">
                <p>{!! nl2br($post->body) !!}</p>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Categorised as <a
                    href="{{ route('category.show', $post->category) }}"><strong>{{$post->category->name}}</strong></a>
            </h6>
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}">Edit</a>
            @endcan
            <h6>Tags {!! $post->tagsAsLinks() !!}</h6>
        </div>
    </div>
</div>
