<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use App\Models\Color;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsAuthorized
{
    private const ROLE = "admin";
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() != null && self::ROLE == auth()->user()->role) {
            return $next($request);
        }
        throw new AuthException("Admin is not authorize");
    }
}
