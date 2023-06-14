<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        
        $this->authorize('update', $user);
       
        $user->update($request->validated());

        Session::flash('success', 'User Updated!');

        return back();
    }
}
