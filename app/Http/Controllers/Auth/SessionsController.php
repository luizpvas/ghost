<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    /**
     * Renders the sign in page.
     * 
     * @return Illuminate\Http\Response
     */
    function create()
    {
        return view('auth.sessions.create');
    }

    /**
     * Attempts to sign in.
     * 
     * @return Illuminate\Http\Response
     */
    function store()
    {
        $credentials = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $session = Session::for(Auth::user());

            if ($session->isActive()) {
                return reflinks()->redirect('workspaces.index');
            } else {
                return reflinks()->redirectSigned('auth.session_confirmations.create', ['session_id' => $session->id]);
            }
        } else {
            return response()->json(['errors' => ['email' => __('Incorrect email and/or password.')]], 422);
        }
    }
}
