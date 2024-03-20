<?php

namespace App\Http\Controllers;

use App\DTO\Event\CreateEventDTO;
use App\Http\Requests\Events\EventFilterRequest;
use App\Constants\Request\EventRequestConstants;
use App\Factory\Event\CreateEventDTOFactory;
use App\Factory\Event\DeletePhotosEventDTOFactory;
use App\Factory\Event\UploadPhotosEventDTOFactory;
use App\Factory\Event\UploadPhotoEventDTOFactory;
use App\Factory\Event\FilterEventDTOFactory;
use App\Factory\Event\UpdateEventDTOFactory;
use App\Http\Requests\Events\EventCreateRequest;
use App\Http\Requests\Events\EventDeletePhotosRequest;
use App\Http\Requests\Events\EventUploadPhotosRequest;
use App\Services\AuthWrapperService;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{

    public function __construct(
        private readonly EventService $eventService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->eventService->index());
    }
    public function filter(EventFilterRequest $request, FilterEventDTOFactory $eventFilterDTOFactory): JsonResponse
    {
        return response()->json(
            $this->eventService->filterEvents(
                $eventFilterDTOFactory->make($request)
            )
        );
    }
    public function searchEvent(Request $request): JsonResponse
    {
        $title = $request->input(EventRequestConstants::TITLE);
        $description = $request->input(EventRequestConstants::DESCRIPTION);

        return response()->json($this->eventService->searchEvent($title, $description));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(EventCreateRequest $request, CreateEventDTOFactory $createEventDTOFactory): JsonResponse
    {
        return response()->json($this->eventService->create($createEventDTOFactory->make($request)));
    }
    public function update(Request $request, UpdateEventDTOFactory $updateEventDTOFactory, string $id): JsonResponse
    {

        return response()->json($this->eventService->update($updateEventDTOFactory->make($request), $id));
    }

    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->eventService->delete($id)]);
    }
    public function similar(Request $request, string $id): JsonResponse
    {
        return response()->json($this->eventService->similar($id, $request->input(EventRequestConstants::CITY)));
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->eventService->show($id));
    }

    public function addPhotos(
        EventUploadPhotosRequest $request,
        UploadPhotoEventDTOFactory $uploadPhotoEventDTOFactory,
        UploadPhotosEventDTOFactory $uploadPhotosEventDTOFactory,
        string $id
    ) {
        return response()->json(
            $this->eventService->updatePhotos(
                $id,
                $uploadPhotoEventDTOFactory->make($request, $id),
                $uploadPhotosEventDTOFactory->make($request, $id),
            )
        );
    }
    public function getEventsByAuthorId(string $authorId): JsonResponse
    {
        return response()->json($this->eventService->getEventsByAuthorId($authorId));
    }
    public function deletePhotos(
        EventDeletePhotosRequest $request,
        DeletePhotosEventDTOFactory $deletePhotosEventDTOFactory,
        string $id
    ): JsonResponse {
        $deleteDTOPhotos = $deletePhotosEventDTOFactory->make($request, $id);
        return response()->json(
            $this->eventService->deletePhotos(
                $id,
                $deleteDTOPhotos
            )
        );
    }
    public function deleteMainPhoto(string $id): JsonResponse
    {
        return response()->json($this->eventService->deleteMainPhoto($id, ));
    }
}
