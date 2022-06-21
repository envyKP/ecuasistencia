<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
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
        //SGA
        if ( strtoupper( $request->user()->rol) == 'ADMIN' ) {
            return $next($request);
        }else {
            abort(403, $request->user()->name. ' Usted no cuenta con permisos para este módulo');
        }

    }
}
