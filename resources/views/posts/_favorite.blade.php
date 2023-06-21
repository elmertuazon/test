<form id="is-favorite" action="{{ route('user.posts.favorite', $post) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-{{ $post->favorited ? 'primary' : 'danger'}}">Favorite</button>
</form>
