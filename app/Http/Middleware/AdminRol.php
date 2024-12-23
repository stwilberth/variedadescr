<?php

namespace anuncielo\Http\Middleware;

use Closure;

class AdminRol
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
        if ($request->user() && $request->user()->AutorizaRoles('admin')) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
