<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Hr
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
        if(!Auth::user()->isAdminOrHr()) {
            return response(["message"=>"you do not have permission"], 404);
        }
        
        return $next($request);
    }
}
