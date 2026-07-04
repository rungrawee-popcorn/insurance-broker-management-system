<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle incoming request and check user role permission.
     *
     * Usage:
     * role:admin
     * role:admin|agent|staff
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Get authenticated user
        $user = auth()->user();

        // If user is not logged in → block
        if (!$user) {
            abort(403, 'NOT LOGGED IN');
        }

        /**
         * IMPORTANT:
         * Use relationship instead of hardcoded mapping
         */
        $userRole = $user->role?->slug;

        // If user has no role assigned → block
        if (!$userRole) {
            abort(403, 'ROLE NOT FOUND');
        }

        /**
         * Fix Laravel middleware parsing:
         * role:admin|agent sometimes comes as one string
         */
        if (count($roles) === 1 && str_contains($roles[0], '|')) {
            $roles = explode('|', $roles[0]);
        }

        // Clean whitespace
        $roles = array_map('trim', $roles);

        /**
         * Check permission
         */
        if (!in_array($userRole, $roles)) {
            abort(403, "ROLE FAIL: {$userRole}");
        }

        return $next($request);
    }
}