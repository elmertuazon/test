@php
    $classes = 'btn btn-danger';
    if ($post->favorites->count() != 0)
    {
        $classes = ($post->favorites->first()->is_favorite == 0) ? 'btn btn-danger' : 'btn btn-primary';
    }
@endphp
<form id="is-favorite" action="{{ route('favorite', $post) }}" method="POST">
    @csrf
    <button
        type="submit"
        value="{{$post->favorites->count() == 0 ? 0 : $post->favorites->first()->is_favorite}}"
        class="{{$classes}}"
        name="is_favorite">
        Favorite
    </button>
</form>
