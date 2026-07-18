<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VolunteerMiddleware
{

   
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isVolunteer()) {
            abort(403, 'Volunteer access required.');
        }

        return $next($request);
    }
}
