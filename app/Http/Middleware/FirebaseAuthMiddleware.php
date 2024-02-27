<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        dd($token);
        // Verify Firebase token
        // Use Firebase Admin SDK to verify token

        // If token is valid, proceed with the request
        // Otherwise, return an unauthorized response

        return $next($request);
    }
}
