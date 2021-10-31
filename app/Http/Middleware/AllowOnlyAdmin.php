<?php

namespace App\Http\Middleware;

use Closure;

class AllowOnlyAdmin
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
        if(auth()->user()->role->value !== 2){
            return back()->with('info', "You don't have permission");
        }
        return $next($request);
    }
}
