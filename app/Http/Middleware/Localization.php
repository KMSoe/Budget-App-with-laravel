<?php

namespace App\Http\Middleware;

use App\Setting;
use App\User;
use Closure;
use Illuminate\Support\Facades\App;

class Localization
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
        if (auth()->user()) {
            // App::setLocale(auth()->user()->setting->language);
            // App::setLocale(User::find(auth()->user()->id)->setting->language);
        }
        return $next($request);
    }
}
