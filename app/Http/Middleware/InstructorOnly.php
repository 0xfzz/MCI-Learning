<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorOnly
{
    /**
     * Ensure only instructors may proceed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isInstructor()) {
            abort(403);
        }

        return $next($request);
    }
}
