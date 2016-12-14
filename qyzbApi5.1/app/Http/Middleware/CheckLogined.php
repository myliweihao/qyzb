<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //dd('url=',$request->url());

        if (Session::get('user_id')) {
            return $next($request);
        } else {
            return redirect('api/nologin')->with('url', $request->url());
        }

    }
}
