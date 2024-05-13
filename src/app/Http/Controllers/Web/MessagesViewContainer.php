<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\MessageService;
use App\Services\System\DataFormattersService;
use Illuminate\View\View;

class MessagesViewContainer extends Controller
{
    public function __construct(private readonly MessageService       $messageService,
                                private readonly DataFormattersService $dataFormattersService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $content = $this->messageService->showMessages();

        return view('messages.index', $this->dataFormattersService->formatViewResponse($content));
    }
}
