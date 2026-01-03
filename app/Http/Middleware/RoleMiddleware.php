<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Authentication required'], 401);
        }

        if ($request->user()->role !== $role) {
            return response()->json(['message' => 'Unauthorized role'], 403);
        }

        if (!$request->user()->approved) {
            return response()->json(['message' => 'User not approved'], 403);
        }

        return $next($request);
    }
}