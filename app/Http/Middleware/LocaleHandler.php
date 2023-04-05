<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class LocaleHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('locale'))
            Session::put('locale', Config::get('app.locale'));

        if ($request->filled('lang') && array_key_exists($request->lang, Config::get('app.available_locales')))
            Session::put('locale', $request->lang);

        App::setLocale(session()->get('locale'));
        return $next($request);
    }
}
