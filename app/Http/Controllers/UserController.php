<?php

namespace App\Http\Controllers;

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
        $accountInfo = collect($request->validated())->only('name', 'email')->toArray();

        if(!is_null($request->password))
        {
            $accountInfo['password'] = $request->password;
        }

        $request->user()->update($accountInfo);

        Session::flash('success', 'User Updated!');

        return back();
    }
}
