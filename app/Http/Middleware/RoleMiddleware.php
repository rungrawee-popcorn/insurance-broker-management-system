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
     * Example usage:
     * role:admin
     * role:admin|agent
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Get authenticated user
        $user = auth()->user();

        // If user is not logged in, deny access
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Get user's role slug
        $userRole = $user->role?->slug;

        // Check if user's role is allowed
        if (!in_array($userRole, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}