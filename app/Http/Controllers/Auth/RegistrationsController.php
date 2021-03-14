<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationsController extends Controller
{
    /**
     * Renders the registration page.
     * 
     * @return Illuminate\Http\Response
     */
    function create()
    {
        return view('auth.registrations.create');
    }

    /**
     * Attempts to register a new user.
     * 
     * @return Illuminate\Http\Response
     */
    function store()
    {
        $validated = request()->validate([
            'name'     => ['required'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::loginUsingId($user->id);

        return reflinks()->redirect('workspaces.index');
    }
}
