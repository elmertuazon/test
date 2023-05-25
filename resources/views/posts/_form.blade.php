<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>

            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                   id="exampleFormControlInput1"
                   value="{{ old('title', $post->title) }}">

            @error('title')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">Introduction</label>
            <input name="introduction" type="text" class="form-control" id="exampleFormControlInput1"
                   @error('introduction') is-invalid @enderror
                   value="{{ old('introduction', $post->introduction) }}">
            @error('introduction')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">Body</label>
            <textarea name="body" class="form-control" id="exampleFormControlTextarea1" @error('body') is-invalid
                      @enderror
                      rows="3">{{ old('body', $post->body) }}</textarea>

            @error('body')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Author</label>
            <select name="author_id" class="form-control" id="exampleFormControlSelect1"
                    @error('author_id') is-invalid @enderror>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                            @if(old('user_id', $post->user_id) === $user->id) selected @endif>{{ ucwords($user->name) }}</option>
                @endforeach
            </select>

            @error('author_id')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>

            <select name="category_id" class="form-control" id="exampleFormControlSelect1"
                    @error('category_id') is-invalid @enderror>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            @if(old('category_id', $post->category_id) === $category->id) selected @endif>{{ ucwords($category->name) }}</option>
                @endforeach
            </select>

            @error('category_id')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>

    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlSelect2">Tags</label>

            <select name="tags[]" multiple class="form-control" id="exampleFormControlSelect2">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}"
                            @if(in_array($tag->id, old('tags', collect( $post->tags)->pluck('id')->toArray()))) selected @endif
                    >{{ ucwords($tag->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">

            @if($post->id)
                <div class="mb-2">
                    <img src="/{{ $post->image }}"/>
                </div>
            @endif

            <label for="exampleFormControlSelect2">Image</label>
            <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" name="image">

            @error('image')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group" style="margin-top: 10px">
            <a href="/">
                <button type="button" class="btn btn-secondary">Back</button>
            </a>
        </div>
        <div class="form-group" style="margin-top: 10px">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
