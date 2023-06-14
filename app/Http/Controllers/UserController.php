<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function edit()
    {
        return view('user.edit');
    }

    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        Session::flash('success', 'User Updated!');

        return back();
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        auth()->user()->update([
            'password' => $request->password
        ]);

        Session::flash('success', 'User Updated!');

        return back();
    }
}
