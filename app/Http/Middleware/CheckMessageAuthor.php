<?php

namespace App\Http\Middleware;

use App\Services\AuthWrapperService;
use App\Services\MessageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMessageAuthor
{
    public function __construct(
        private MessageService $messageService,
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
        $this->messageService->checkIsAuthor($request->route('id'), $this->authWrapperService->getAuthIdentifier());
        return $next($request);
    }
}
