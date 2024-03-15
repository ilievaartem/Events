<?php

namespace App\Http\Controllers;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Event\CreateEventDTO;
use App\Http\Requests\Events\EventCreateRequest;
use App\Services\AuthWrapperService;
use App\Services\EventArchiveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventArchiveController extends Controller
{
    public function __construct(
        private EventArchiveService $eventArchiveService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(): JsonResponse
    {
        return response()->json($this->eventArchiveService->index());
    }
    public function archive(string $eventId): JsonResponse
    {
        return response()->json($this->eventArchiveService->archive($eventId));
    }
    public function showUserEventArchives(string $userId): JsonResponse
    {
        return response()->json($this->eventArchiveService->showUserEventArchives($userId));
    }
    public function unarchive(EventCreateRequest $request, string $id): JsonResponse
    {
        $createEventDTO = new CreateEventDTO(

            title: $request->input(EventRequestConstants::TITLE),
            longitude: $request->input(EventRequestConstants::LONGITUDE),
            latitude: $request->input(EventRequestConstants::LATITUDE),
            additionalAuthors: $request->input(EventRequestConstants::ADDITIONAL_AUTHOR),
            description: $request->input(EventRequestConstants::DESCRIPTION),
            shortDescription: $request->input(EventRequestConstants::SHORT_DESCRIPTION),
            streetName: $request->input(EventRequestConstants::STREET_NAME),
            building: $request->input(EventRequestConstants::STREET_NAME),
            placeName: $request->input(EventRequestConstants::PLACE_NAME),
            corpus: $request->input(EventRequestConstants::CORPUS),
            apartment: $request->input(EventRequestConstants::APARTMENT),
            placeDescription: $request->input(EventRequestConstants::PLACE_DESCRIPTION),
            startDate: $request->input(EventRequestConstants::START_DATE),
            startTime: $request->input(EventRequestConstants::START_TIME),
            finishDate: $request->input(EventRequestConstants::FINISH_DATE),
            finishTime: $request->input(EventRequestConstants::FINISH_TIME),
            age: $request->input(EventRequestConstants::AGE),
            categoriesIds: $request->input(EventRequestConstants::CATEGORIES_IDS),
            tagsIds: $request->input(EventRequestConstants::TAGS_IDS),
            appliers: $request->input(EventRequestConstants::APPLIERS),
            interestars: $request->input(EventRequestConstants::INTERESTARS),
            rating: $request->input(EventRequestConstants::RATING),
            authorId: $this->authWrapperService->getAuthIdentifier(),
            parentId: $request->input(EventRequestConstants::PARENT_ID),
            cityId: $request->input(EventRequestConstants::CITY_ID),
            countryId: $request->input(EventRequestConstants::COUNTRY_ID),
        );
        return response()->json($this->eventArchiveService->unarchive($id, $createEventDTO));
    }

    public function delete(string $id): JsonResponse
    {
        return response()->json($this->eventArchiveService->delete($id));

    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->eventArchiveService->show($id));

    }
}
