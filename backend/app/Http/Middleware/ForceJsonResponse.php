<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware class that ensures all incoming HTTP requests have the 'Accept'
 * header set to 'application/json'.
 * This forces the application to return JSON responses.
 */
final class ForceJsonResponse
{
    /**
     * Handles an incoming HTTP request and modifies its headers to always accept JSON responses.
     *
     * @param Request $request The incoming HTTP request instance.
     * @param Closure $next The callback to pass the request to the next middleware.
     * @return mixed The response from the next middleware after processing the request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
