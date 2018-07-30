<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ReauthenticateController extends Controller
{
    public function reauthenticate()
    {
        return view('auth/reauthenticate');
    }

    public function processReauthenticate(Request $request)
    {
        $username = session()->get('username');
        $password = $request->get("password");

        $alt = User::where('username', $username)->value('salt');
        if (hash('sha256', $password.$alt) === User::where('username', $username)->value('password'))
        {
            session()->put('reauthenticate.valid', true);
            return redirect()->to(session()->get('reauthenticate.requested_url', '/'));
        }

        return back()->with('message', 'Incorrect password please try again');
    }
}
