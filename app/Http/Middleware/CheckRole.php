<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Please login first',
            ], 401);
        }

        // Check if user has the required role
        if ($request->user()->role !== $role) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: You do not have permission to access this resource',
            ], 403);
        }

        return $next($request);
    }
}
