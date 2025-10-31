<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! method_exists($request->user(), 'isStudent') || ! $request->user()->isStudent()) {
            abort(403);
        }

        return $next($request);
    }
}
