<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        // Check if the user is authenticated and has the required role
        if (!Auth::check() || !in_array(Auth::user()->role, $role)) {
            // Avoid redirect loop by checking if the current route is not the login route
            if ($request->path() !== 'login') {
                return redirect('/login');
            }
            // If already on the login route, abort with a 403 status code
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
