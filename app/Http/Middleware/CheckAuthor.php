<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $commentId = $request->route('id'); // Assuming your route parameter is named 'commentId'

        $comment = Comment::find($commentId)->toArray();

        if (auth()->user()->getAuthIdentifier() == $comment['author_id']) {
            return $next($request);
        }
        throw new AuthException("Current user did not create that comment");

    }
}
