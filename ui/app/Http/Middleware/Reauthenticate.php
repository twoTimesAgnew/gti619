<?php

namespace App\Http\Middleware;

use Closure;

class Reauthenticate
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
        if(session()->has('username') && !session()->has('reauthenticate.valid'))
        {
            $request->session()->put('reauthenticate.requested_url', $request->route()->uri());
            return redirect('reauthenticate');
        }

        return $next($request);
    }
}
