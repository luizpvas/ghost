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
                Auth::logout();
                return reflinks()->redirectSigned('auth.session_confirmations.create', ['session_id' => $session->id]);
            }
        } else {
            $validation = ['email' => [__('Incorrect email and/or password.')]];
            return response()->json(['errors' => $validation], 422);
        }
    }

    /**
     * Signs out.
     * 
     * @return Illuminate\Http\Response
     */
    function destroy()
    {
        Auth::logout();
        return reflinks()->redirect('auth.sessions.create');
    }
}
