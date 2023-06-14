<div class="card">
    <div class="card-body">
        <img src="https://i.pravatar.cc/100?u={{$comment->id}}" alt="" width="60" height="60" class="rounded-xl" />
        <p class="text-xs">{{$comment->author->name}}</p>
        <p class="text-xs">Posted <time>{{$comment->created_at->diffForHumans()}}</time></p>
        <h4 class="mt-4"><em>{{$comment->body}}</em></h4>
    </div>
</div>