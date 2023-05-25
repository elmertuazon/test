@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @method('PUT')    
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>
            @error('title')
                <p style="color:red">required</p>
            @enderror
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="{{ $post->title }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Introduction</label>
            @error('introduction')
                <p style="color:red">required</p>
            @enderror
            <input name="introduction" type="text" class="form-control" id="exampleFormControlInput1" value="{{ $post->introduction }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Body</label>
            @error('body')
                <p style="color:red">required</p>
            @enderror
            <textarea name="body" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $post->body }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Author</label>
            @error('author_id')
                <p style="color:red">required</p>
            @enderror
            <select name="author_id" class="form-control" id="exampleFormControlSelect1">
                <option value="{{ $post->author->id }}">{{ $post->author->name }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" selected>{{ ucwords($user->name) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>
            @error('category_id')
                <p style="color:red">required</p>
            @enderror
            <select name="category_id" class="form-control" id="exampleFormControlSelect1">
                <option value="{{ $post->category->id }}" selected>{{ ucwords($post->category->name) }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Tags</label>
            @error('tags')
                <p style="color:red">required</p>
            @enderror
            <select name="tags" multiple class="form-control" id="exampleFormControlSelect2">
            @foreach ($post->tags as $tag)
                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
            @endforeach
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ ucwords($tag->name) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Image</label>
            @if ($post->image)
                <img src="{{ public_path($post->image) }}" />
            @endif
            <input type="file" accept="image/*" class="form-control" id="exampleFormControlSelect2" name="image">
        </div>
        <div class="form-group" style="margin-top: 10px">
        <a href="/"><button type="button" class="btn btn-secondary">Back</button></a>
        </div>
        <div class="form-group" style="margin-top: 10px">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection