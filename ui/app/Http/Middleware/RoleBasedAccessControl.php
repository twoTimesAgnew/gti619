<?php

namespace App\Http\Middleware;

use Closure;

class RoleBasedAccessControl
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
        User::where('username', session()->get('username'))->value('role')
        return $next($request);
    }
}
