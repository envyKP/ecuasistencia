<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            //return route('login');
            /*
                SGA en este middleware se realizo cambios para que usuarios no logeados no obtengan respuestas 302
                de otras rutas
            */
            return abort(410, 'that page does not exist...');
        }

    }
}
