<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocalMiddleware
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
        $local = null;

        if(Auth::check() && !Session::has('locale'))
        {
            $local = $request->user()->local;
            Session::put('locale',$local);
        }

        if($request->has('local'))
        {
            $local = $request->get('local');
            Session::put('locale',$local);
        }

        $local = Session::get('locale');

        if($local === null)$local = config('app.fallback_locale');
        

        App::setLocale($local);

        return $next($request);
    }
}
