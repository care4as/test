<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class hasRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $right)
    {
        $user = Auth::user();


        if(!in_array($right,$user->rights()))
        {
          abort(403,'Nicht authoriziert! Dir fehlt das Recht: '.$right);
        }
        return $next($request);
    }
}
