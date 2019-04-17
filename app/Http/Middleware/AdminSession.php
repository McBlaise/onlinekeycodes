<?php

namespace App\Http\Middleware;

use Closure;

class AdminSession
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
        if(session('ls_id') != 0){
            return response()->json(array('msg' => 'not logged in as Admin'));
        }

        return $next($request);
    }
}
