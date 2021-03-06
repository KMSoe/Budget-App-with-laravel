<?php

namespace App\Http\Middleware;

use App\Setting;
use App\User;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            $setting = Setting::where('user_id', Auth::user()->id)->get();
            App::setLocale($setting[0]->language);
        }
        return $next($request);
    }
}
