<?php

namespace App\Http\Controllers;

class WorkspacesController extends Controller
{
    /**
     * Lists workspaces.
     * 
     * @return Illuminate\Http\Response
     */
    function index()
    {
        return view('workspaces.index');
    }
}
