<?php

namespace App\Http\Middleware;

use App\Services\AuthWrapperService;
use App\Services\MediaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMediaAuthor
{
    public function __construct(
        private MediaService $mediaService,
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
        $this->mediaService->checkIsAuthor($request->route('id'), $this->authWrapperService->getAuthIdentifier());
        return $next($request);

    }
}
