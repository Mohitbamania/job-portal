<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in
        if (!Auth::check()) {
            return redirect()
                ->route('home')
                ->with('info', 'You need to log in to access this page.');
        }

        // If logged in but no user object (rare case)
        if ($request->user() == null) {
            return redirect()
                ->route('home')
                ->with('warning', 'You need to log in to access this page.');
        }

        // If logged in but not admin
        if (!in_array($request->user()->role, ['admin', 'sub_admin', 'super_admin'])) {
            return redirect()
                ->route('account.profile')
                ->with('warning', 'You are not authorized to access this page.');
        }

        // Otherwise, allow access
        return $next($request);
    }
}
