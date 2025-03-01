<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthAdmin
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
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Redirect authenticated admins to the dashboard
        }

        return $next($request); // Allow unauthenticated users to proceed
    }
} 