<?php

namespace App\Http\Middleware;

use App\Services\AuthWrapperService;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsUserBanned
{
    public function __construct(
        private UserService $userService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->userService->checkIsUserBanned($this->authWrapperService->getAuthIdentifier());
        return $next($request);
    }
}
