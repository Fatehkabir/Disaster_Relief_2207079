<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitorMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $request->session()->put('visitor_ip', $request->ip());
        return $next($request);
    }
}
