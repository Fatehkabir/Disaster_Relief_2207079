<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VictimMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isVictim()) {
            abort(403, 'Victim access required.');
        }

        return $next($request);
    }
}
