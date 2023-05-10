<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('posts.show', ['post'=>$item->id])}}"><h2>{{$item->title}}</h2></a>

            <h6>{{$item->created_at->format('d/m/Y \a\t H:i')}}</h6>
        </div>
        <h6>By {{$item->author}}</h6>
    </div>
    <div class="card-body">
        <p>Introduction {{$item->introduction}}</p>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>{{$item->body}}</p>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Categorised as <strong>{{$item->category->name}}</strong></h6>
            <h6>Tags {{ $item->tags->map(fn($tag) => "#$tag->name")->join(', ') }}</h6>
        </div>
    </div>
</div>
