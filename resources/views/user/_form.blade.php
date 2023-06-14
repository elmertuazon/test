<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="name">Name</label>

            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   value="{{ old('name', auth()->user()->name) }}">

            @error('name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="email">Email</label>

            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   value="{{ old('email', auth()->user()->email) }}">

            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="password">Password</label>

            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Please fill in *only* if you want to change your password" id="password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>

    <div class="col-12 d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary">Back</button>
    </div>
</div>
