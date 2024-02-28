<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $tokenVerified = getCurrentUserDetails(true);
            if ($tokenVerified) {
                return $next($request);
            }
        } catch (\Throwable $th) {
            return response()
                ->json(setErrorResponse($th->getMessage()))
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
    }
}
