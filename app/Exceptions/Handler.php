<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register(): void
    {
        $this->renderable(function (AuthException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        });
        $this->renderable(function (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        });
        $this->renderable(function (BadRequestException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        });
        $this->renderable(function (ConflictException $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        });
        $this->renderable(function (ForbiddenException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        });

    }
}
