<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Language
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->language) {
            App::setLocale(Auth::user()->language->code);
        }
        elseif (Session()->has('applocale') && array_key_exists(Session()->get('applocale'), config('languages'))) {
            App::setLocale(Session()->get('applocale'));
        }
        else {
            App::setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
