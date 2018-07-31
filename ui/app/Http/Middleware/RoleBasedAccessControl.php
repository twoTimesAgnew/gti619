<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Access;
use App\Page;

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
        # Check if user has right to access $request->route()->uri()
        $id_role = User::where('username', session()->get('username'))->value('role');
        $id_page = Page::where('uri', $request->route()->uri())->value('id');

        $access = Access::where('id_role', $id_role)->where('id_page', $id_page)->get();

        if(!empty($access[0]))
        {
            return $next($request);
        }
        else
        {
            return back();
        }
    }
}
