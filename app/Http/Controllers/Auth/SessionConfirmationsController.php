<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class SessionConfirmationsController extends Controller
{
    /**
     * Renders the confirmatio page.
     * 
     * @return Illuminate\Http\Response
     */
    function create()
    {
        if (!request()->hasValidSignature()) {
            return abort(401);
        }

        if ($session = Session::find(request('session_id'))) {
            if ($session->isActive()) {
                return view('auth.session_confirmations.already_active');
            }
        } else {
            $session = new Session();
        }

        return view('auth.session_confirmations.create', compact('session'));
    }

    /**
     * Attempts to confirm the session by comparing the confirmation code.
     * 
     * @return Illuminate\Http\Response
     */
    function store()
    {
        $validated = request()->validate([
            'session_id' => 'required',
            'confirmation_code' => 'required'
        ]);

        $session = Session::findOrFail($validated['session_id']);

        if ($session->confirmation_code == $validated['confirmation_code']) {
            $session->activate();
            Auth::loginUsingId($session->user->id);
            return reflinks()->redirect('workspaces.index');
        } else {
            $validation = ['confirmation_code' => [__('Invalid code. Are you sure you copied it from the right email?')]];
            return response()->json(['errors' => $validation], 422);
        }
    }
}
