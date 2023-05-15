<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('posts.show', $post )}}"><h2>{{$post->title}}</h2></a>

            <h6>{{$post->created_at->format('d/m/Y \a\t H:i')}}</h6>
        </div>
        <h6>By {{$post->author->name}}</h6>
    </div>
    <div class="card-body">
        <p>Introduction {{$post->introduction}}</p>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>{{$post->body}}</p>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Categorised as <strong>{{$post->category->name}}</strong></h6>
            <h6>Tags {{ $post->tags->map(fn($tag) => "#$tag->name")->join(', ') }}</h6>
        </div>
    </div>
</div>
