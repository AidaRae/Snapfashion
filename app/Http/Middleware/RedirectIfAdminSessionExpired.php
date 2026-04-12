<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is authenticated as an admin
        $admin = Auth::guard('admin')->user();

        // If the admin is not logged in or the admin info does not exist in the database
        if (!$admin || !$admin->exists) {
            // If the session has expired or admin info is missing, redirect to the login page for admin
            return redirect()->route('admin.login')->with('message', 'Your session has expired or your account no longer exists. Please login again.');
        }

        return $next($request);
    }
}
