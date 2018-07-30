<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cookie::get('sober_sec_session') && session()->exists(Cookie::get('sober_sec_session')))
        {
            return redirect('home');
        }

        return view('auth/login');
    }

    public function validateLogin(Request $request)
    {
        $username = $request->get("username");
        $password = $request->get("password");

        $alt = User::where('username', $username)->value('salt');
        if (hash('sha256', $password.$alt) === User::where('username', $username)->value('password'))
        {
            Log::channel('connections')->info("[$username] successfully authenticated from [" . $request->ip() . "]");
            session()->put($request->cookie('sober_sec_session'), $username);
            session()->put('username', $username);
            return redirect('home');
        }

        Log::channel('connections')->error("Invalid password was entered for [$username] from [" . $request->ip() . "]");

        # Add invalid attempts logic
    }

    public function logout()
    {
        if(Cookie::get('sober_sec_session') && session()->exists(Cookie::get('sober_sec_session')))
        {
            Log::channel('connections')->info("[" . session()->get('username') . "] signing out.");
            session()->flush();
            Log::channel('connections')->info("Session flushed successfully.");
            return redirect('login');
        }
    }


}
