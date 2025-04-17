<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        if (!auth()->check()) {
//            return response()->json(['message' => 'Unauthenticated'], 401);
//        }

        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Forbidden for normal users'], 403);
        }

        return $next($request);
    }
}
