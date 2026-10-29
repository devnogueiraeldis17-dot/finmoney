<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) return redirect()->route('login');
        abort_unless($request->user()->isAdmin(), 403, 'Acesso permitido somente ao administrador.');

        return $next($request);
    }
}
