<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->is_admin || auth()->user()->role === 'admin')) {
            return redirect()->route('admin.dashboard')->with('error', 'Akun Admin tidak diperbolehkan mengakses fitur publik.');
        }

        return $next($request);
    }
}