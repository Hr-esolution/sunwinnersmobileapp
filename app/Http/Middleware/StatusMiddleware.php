<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
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
        if (!$request->user()) {
            return response()->json(['message' => 'Authentication required'], 401);
        }

        if (!$request->user()->approved) {
            return response()->json(['message' => 'User not approved'], 403);
        }

        if ($request->user()->status === 'suspended') {
            return response()->json(['message' => 'User account suspended'], 403);
        }

        return $next($request);
    }
}