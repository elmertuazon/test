<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">name</label>

            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   id="exampleFormControlInput1"
                   value="{{ old('name', $user->name) }}">

            @error('name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">email</label>

            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   id="exampleFormControlInput1"
                   value="{{ old('email', $user->email) }}">

            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="exampleFormControlInput1">password</label>

            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   id="exampleFormControlInput1"
                   value="{{ old('password', $user->password) }}">

            @error('password')
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
