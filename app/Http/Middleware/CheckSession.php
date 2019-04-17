<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        if(!session()->has('id') && !session()->has('ls_id')){
            return response()->json(array('msg' => 'no active session'), 200);
        }

        return $next($request);
    }
}
