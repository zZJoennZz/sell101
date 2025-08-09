<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = 1): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== $role) {
            // abort(403);
            return redirect()->route('public.home')->withErrors(['error' => 'You do not have permission to access this page.']);
        }

        return $next($request);
    }
}
