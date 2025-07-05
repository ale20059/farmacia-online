<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotCliente
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('cliente')->check()) {
            return redirect()->route('cliente.login');
        }

        return $next($request);
    }
}
