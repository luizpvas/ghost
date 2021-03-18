<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class PasswordsController extends Controller
{
    /**
     * Renders the edit password page.
     * 
     * @param  User $user
     * @return Illuminate\Http\Response
     */
    function edit(User $user)
    {
        $this->authorize('edit', $user);
        return view('auth.passwords.edit', compact('user'));
    }

    function update(User $user)
    {
        $validated = request()->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'min:8']
        ]);

        if (Hash::check($validated['current_password'], $user->password)) {
            $user->update(['password' => Hash::make($validated['new_password'])]);
            return reflinks()
                ->toast('success', __('Password updated.'))
                ->redirect('auth.profiles.edit', $user);
        } else {
            $validation = ['current_password' => [__("Current password doesn't match.")]];
            return response()->json(['errors' => $validation], 422);
        }
    }
}
