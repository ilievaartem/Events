<?php

namespace App\Factory\Event;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\UpdateEventDTO;
use App\Services\AuthWrapperService;
use Illuminate\Http\Request;

class UpdateEventDTOFactory
{

    public function make(Request $request): UpdateEventDTO
    {
        return new UpdateEventDTO(
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
            parentId: $request->input(EventRequestConstants::PARENT_ID),
            placeId: $request->input(EventRequestConstants::PLACE_ID),
        );
    }
}
