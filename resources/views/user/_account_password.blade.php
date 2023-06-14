<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="name">Current password</label>

            <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror"
                   id="current_password">

            @error('current_password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="name">New password</label>

            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   id="password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>

    <div class="col-12 mb-2">
        <div class="form-group">
            <label for="name">Confirm new password</label>

            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                   id="password_confirmation">

            @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    <div class="col-12 d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Update password</button>
    </div>
</div>
