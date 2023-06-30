<form id="is-favorite" action="{{ route('user.links.favorite', $link) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-{{ $link->favorited ? 'primary' : 'danger'}}">Favorite</button>
</form>
