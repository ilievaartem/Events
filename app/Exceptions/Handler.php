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

    /**
     * Register the exception handling callbacks for the application.
     */
    // public function render($request, Exception $exception)
    // {
    //     return response()->json([
    //         'type' => get_class($exception),
    //         'message' => $exception->getMessage()
    //     ]);
    // }

    public function register(): void
    {
        $this->renderable(function (AuthException $e) {
            return response()->json($e->getMessage(), 400);
        });
        $this->renderable(function (NotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        });
        $this->renderable(function (AlreadyExistException $e) {
            return response()->json($e->getMessage(), 404);
        });

    }
}
