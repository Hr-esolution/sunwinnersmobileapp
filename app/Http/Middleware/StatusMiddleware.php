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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthenticated.'
            ], 401);
        }

        // Only approved users can access (except for clients who are auto-approved)
        if ($request->user()->role === 'technician' && !$request->user()->approved) {
            return response()->json([
                'error' => 'Unauthorized. Your account is not approved yet.'
            ], 403);
        }

        if ($request->user()->role === 'owner' && !$request->user()->approved) {
            return response()->json([
                'error' => 'Unauthorized. Your account is not approved yet.'
            ], 403);
        }

        // Check if user is suspended (if you have a suspended status)
        if (method_exists($request->user(), 'isSuspended') && $request->user()->isSuspended()) {
            return response()->json([
                'error' => 'Unauthorized. Your account is suspended.'
            ], 403);
        }

        return $next($request);
    }
}