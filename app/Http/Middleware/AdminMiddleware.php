<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()?->role !== 'admin') {
            return response()->json([
                'message' => 'Only admins can perform this action.'
            ], 403);
        }

        return $next($request);
    }
}
