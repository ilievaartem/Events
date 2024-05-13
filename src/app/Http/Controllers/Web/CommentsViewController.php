<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use App\Services\System\DataFormattersService;
use Illuminate\View\View;

class CommentsViewController extends Controller
{
    public function __construct(private readonly CommentService        $commentService,
                                private readonly DataFormattersService $dataFormattersService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $content = $this->commentService->showComments();

        return view('comments.index', $this->dataFormattersService->formatViewResponse($content));
    }
}
