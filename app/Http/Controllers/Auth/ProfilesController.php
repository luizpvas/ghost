<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfilesController extends Controller
{
    /**
     * Renders the edit page if authorized.
     * 
     * @param  User $user
     * @return Illuminate\Http\Response
     */
    function edit(User $user)
    {
        $this->authorize('edit', $user);
        return view('auth.profiles.edit', compact('user'));
    }

    /**
     * Attempts to update the user's profile.
     * 
     * @param  User $user
     * @return Illuminate\Http\Response
     */
    function update(User $user)
    {
        $this->authorize('edit', $user);

        $validated = request()->validate([
            'name'                      => ['sometimes', 'required'],
            'avatar'                    => ['sometimes', 'file'],
            'two_factor_authentication' => ['sometimes', 'required']
        ]);

        $user->update($validated);

        return reflinks()->redirect('auth.profiles.edit', $user);
    }
}
