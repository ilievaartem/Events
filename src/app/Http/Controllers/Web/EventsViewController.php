<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\NotFoundException;
use App\Factory\Event\CreateEventDTOFactory;
use App\Factory\Event\FilterEventDTOFactory;
use App\Factory\Event\UpdateEventDTOFactory;
use App\Http\Controllers\Api\Controller;
use App\Services\CommentService;
use App\Services\EventService;
use App\Services\QuestionService;
use App\Services\System\DataFormattersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventsViewController extends Controller
{
    public function __construct(
        private readonly EventService          $eventService,
        private readonly DataFormattersService $dataFormattersService,
        private readonly CommentService        $commentService,
        private readonly QuestionService       $questionService
    )
    {
    }

    /**
     * @param Request $request
     * @param FilterEventDTOFactory $filterEventDTOFactory
     * @return View
     */
    public function filterEvents(Request $request, FilterEventDTOFactory $filterEventDTOFactory) : View
    {
        $content = $this->eventService->filterEvents($filterEventDTOFactory->make($request));

        return view('events.index', $this->dataFormattersService->formatViewResponse($content));
    }

    /**
     * @return View
     */
    public function showCreate(): View
    {
        $content = $this->eventService->getTables();

        return view('events.create', ['content' => $content]);
    }

    /**
     * @param string $id
     * @return View
     * @throws NotFoundException
     */
    public function viewEvent(string $id): View
    {
        $content = $this->eventService->show($id);

        return view('events.show', [
            'content' => $content,
            'viewOnly' => true,
            'eventId' => $id
        ]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function showComments(string $id): View
    {
        $content = $this->commentService->showCommentsOfEvent($id);

        return view('comments.show-event', [
            ...$this->dataFormattersService->formatViewResponse($content),
            'eventId' => $id
        ]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function showQuestions(string $id): View
    {
        $content = $this->questionService->showQuestionsOfEvent($id);

        return view('questions.show-event', [
            ...$this->dataFormattersService->formatViewResponse($content),
            'eventId' => $id
        ]);
    }

    /**
     * @param string $id
     * @return View
     * @throws NotFoundException
     */
    public function show(string $id): View
    {
        $content = $this->eventService->show($id);
        $tables = $this->eventService->getTables();

        return view('events.show', [
            'content' => $content,
            'viewOnly' => false,
            'tables' => $tables,
            'eventId' => $id
        ]);
    }

    /**
     * @param Request $request
     * @param CreateEventDTOFactory $createEventDTOFactory
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function create(Request $request, CreateEventDTOFactory $createEventDTOFactory): RedirectResponse
    {
        $this->eventService->create($createEventDTOFactory->make($request));

        return redirect()->route('events.index');
    }

    /**
     * @param Request $request
     * @param string $id
     * @param UpdateEventDTOFactory $updateEventDTOFactory
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function update(Request $request, string $id, UpdateEventDTOFactory $updateEventDTOFactory): RedirectResponse
    {
        $this->eventService->update($updateEventDTOFactory->make($request), $id);

        return redirect()->back();
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $this->eventService->delete($id);

        return redirect()->route('events.index');
    }
}
