@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>
            @error('title')
                <p style="color:red">required</p>
            @enderror
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Introduction</label>
            @error('introduction')
                <p style="color:red">required</p>
            @enderror
            <input name="introduction" type="text" class="form-control" id="exampleFormControlInput1" value="{{ old('introduction') }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Body</label>
            @error('body')
                <p style="color:red">required</p>
            @enderror
            <textarea name="body" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('body') }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Author</label>
            @error('author_id')
                <p style="color:red">required</p>
            @enderror
            <select name="author_id" class="form-control" id="exampleFormControlSelect1">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ ucwords($user->name) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>
            @error('category_id')
                <p style="color:red">required</p>
            @enderror
            <select name="category_id" class="form-control" id="exampleFormControlSelect1">
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
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ ucwords($tag->name) }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Image</label>
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