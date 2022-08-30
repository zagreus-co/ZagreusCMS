<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class checkLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( !Session::has('locale') )
            Session::put('locale', Config::get('app.locale'));
        
        if (isset($_GET['lang']) && array_key_exists($_GET['lang'], Config::get('app.available_locales')))
            Session::put('locale', $_GET['lang']); 

        App::setLocale(session('locale'));
        return $next($request);
    }
}
