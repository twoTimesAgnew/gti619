<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function validateLogin(Request $request)
    {
        # If unsuccessful login previously, check to make sure timeout is over
        if(Redis::exists("timeout.{$request->ip()}"))
        {
            Log::channel('connections')->error("[" . $request->ip() . "] attempted to login before timeout expired");
            return back()->with('message', 'Please try again in a few moments.');
        }

        $username = $request->get("username");
        $password = $request->get("password");

        # Get user's salt
        $alt = User::where('username', $username)->value('salt');

        # Validate password
        if (hash('sha256', $password.$alt) === User::where('username', $username)->value('password'))
        {

            if(Redis::exists("attempts.{$request->ip()}:$username"))
            {
                Redis::del("attempts.{$request->ip()}:$username");
            }

            Log::channel('connections')->info("[$username] successfully authenticated from [" . $request->ip() . "]");
            session()->put($request->cookie('sober_sec_session'), $username);
            session()->put('username', $username);

            return redirect('home');
        }

        # Password did not match
        # IP + user already has a failed login within last 120 secs
        if(Redis::exists("attempts.{$request->ip()}:$username"))
        {
            $attempts = Redis::get("attempts.{$request->ip()}:$username");
            $maxAttempts = (int) Setting::value('pass_attempts');
            $numLeft = $maxAttempts-$attempts;

            Log::channel('connections')->error("Invalid password was entered for [$username] from [" . $request->ip() . "] $numLeft attempts remaining.");

            # If current failed attempt == max attempts
            if($attempts+1 == $maxAttempts)
            {
                Log::channel('connections')->error("[$username] from [" . $request->ip() . "] locked out due to max attempts being reached.");
                if($username !== 'Administrateur')
                {
                    $user = User::where('username', $username)->first();
                    $user->password = hash('sha256', hash('sha256', str_random(26)).$user->salt);
                    $user->save();
                }
                return back()->with('message', 'Max number of attempts reached. Please contact an administrator for assistance.');
            }
            else
            {
                # Increment attempts for this IP + user
                Redis::incr("attempts.{$request->ip()}:$username");
            }
        }
        else
        {
            # No failed attempts within last 120 secs, create in redis
            Redis::setex("attempts.{$request->ip()}:$username", 120, 1);
        }

        if(!Redis::exists("timeout.{$request->ip()}"))
        {
            # Create timeout in redis
            Redis::setex("timeout.{$request->ip()}", Setting::value('pass_attempts_delay'), true);
        }

        return back()->with('message', 'Incorrect login/password. Please try again.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
