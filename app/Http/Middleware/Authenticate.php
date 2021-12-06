<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Authenticate
 */
class Authenticate extends Middleware
{
    /**
     * Obtiene la ruta a donde el usuario debe redireccionarse cuando no esta autenticado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
