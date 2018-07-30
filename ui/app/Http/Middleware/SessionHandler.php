<?php

namespace App\Http\Middleware;

use Closure;

class SessionHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has($request->cookie('sober_sec_session')) && session()->get($request->cookie('sober_sec_session')) == session()->get('username'))
        {
            return $next($request);
        }

        return redirect('login');
    }
}
