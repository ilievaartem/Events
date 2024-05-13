<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Services\QuestionService;
use App\Services\System\DataFormattersService;
use Illuminate\View\View;

class QuestionsViewController extends Controller
{
    public function __construct(private readonly QuestionService       $questionService,
                                private readonly DataFormattersService $dataFormattersService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $content = $this->questionService->showQuestions();

        return view('questions.index', $this->dataFormattersService->formatViewResponse($content));
    }
}
