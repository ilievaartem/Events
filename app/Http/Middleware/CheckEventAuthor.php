<?php

namespace App\Http\Middleware;

use App\Services\AuthWrapperService;
use App\Services\EventService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventAuthor
{
    public function __construct(
        private EventService $eventService,
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
        $this->eventService->checkIsAuthor($request->route('id'), $this->authWrapperService->getAuthIdentifier());
        return $next($request);
    }
}
