<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;

class SignInByEmailOnlyController extends Controller
{
    /**
     * Renders the sign in by email only page.
     * 
     * @return Illuminate\Http\Response
     */
    function create()
    {
        return view('auth.sign_in_by_email_only.create');
    }

    /**
     * Attempts to sign in by email only.
     * 
     * @return Illuminate\Http\Response
     */
    function store()
    {
        if ($user = User::where('email', request('email'))->first()) {
            $session = Session::createInPendingState($user);
            return reflinks()->redirectSigned('auth.session_confirmations.create', ['session_id' => $session->id, 'email' => request('email')]);
        }

        return reflinks()->redirectSigned('auth.session_confirmations.create', ['email' => request('email')]);
    }
}
