<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>

            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                   id="exampleFormControlInput1"
                   value="{{ old('title', $link->title) }}">

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
            <input name="introduction" type="text" class="form-control @error('introduction') is-invalid @enderror" id="exampleFormControlInput1"
                   value="{{ old('introduction', $link->introduction) }}">
            @error('introduction')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">Url</label>
            <input type="text" class="form-control" name="url" value="{{ old('url', $link->url) }}" placeholder="https://example.com">
            @error('url')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>

            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="exampleFormControlSelect1">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            @if(old('category_id', $link->category_id) === $category->id) selected @endif>{{ ucwords($category->name) }}</option>
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
                            @if(in_array($tag->id, old('tags', collect( $link->tags)->pluck('id')->toArray()))) selected @endif
                    >{{ ucwords($tag->name) }}</option>
                @endforeach
            </select>
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
