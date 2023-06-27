<div class="card">
    <div class="card-body">
        <div>
            <img src="https://i.pravatar.cc/100?u={{$comment->id}}" alt="" width="60" height="60" class="rounded-xl"/>
            <p class="text-xs">{{$comment->author->name}}</p>
            <p class="text-xs">Posted
                <time>{{$comment->created_at->diffForHumans()}}</time>
            </p>
            <h4 class="mt-4"><em>{{$comment->body}}</em></h4>
        </div>
        <div>
            <form method="POST" action="{{ route('user.comments.comments', $comment) }}">
                @csrf
                <div class="d-flex flex-column align-items-end">
                    <label for="reply_to_comment"></label>
                    <textarea name="body" rows="5" class="form-control" name="" id="" cols="30" rows="10"
                              style="width: 100%"></textarea>
                    <button type="submit" class="btn btn-sm btn-outline-info mt-2" style="width: 100px">Comment</button>
                </div>
            </form>
        </div>
        @foreach ($comment->comments as $comment)
                        @include('comments.index')
                    @endforeach
    </div>
</div>
