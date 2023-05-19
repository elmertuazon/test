<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('posts.show', $post )}}"><h2>{{$post->title}}</h2></a>

            <h6>{{$post->created_at->format('d/m/Y \a\t H:i')}}</h6>
        </div>
        <h6>By {{$post->author->name}}</h6>
    </div>
    <div class="card-body">
        <div class="fakeimg" style="height:200px;">Image</div>
        <h4 class="mt-4"><em>Introduction {{$post->introduction}}</em></h4>

        <div class="mt-4">
            <p>{!! nl2br($post->body) !!}</p>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Categorised as <a href="{{ route('category.show', $post->category) }}"><strong>{{$post->category->name}}</strong></a></h6>
            <h6>Tags {!! $post->tagsAsLinks() !!}</h6>
        </div>
    </div>
</div>
