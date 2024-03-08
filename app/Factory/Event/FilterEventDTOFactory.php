<?php

namespace App\Factory\Event;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Event\FilterEventDTO;
use Illuminate\Http\Request;

class FilterEventDTOFactory
{
    public function make(Request $request): FilterEventDTO
    {
        return new FilterEventDTO(
            phrase: $request->input(EventRequestConstants::PHRASE),
            longitude: $request->input(EventRequestConstants::LONGITUDE),
            latitude: $request->input(EventRequestConstants::LATITUDE),
            geoRadius: $request->input(EventRequestConstants::GEO_RADIUS),
            searchBy: $request->input(EventRequestConstants::SEARCH_BY) != null
            ? array_flip($request->input(EventRequestConstants::SEARCH_BY))
            : $request->input(EventRequestConstants::SEARCH_BY),
            startDateMin: $request->input(EventRequestConstants::START_DATE_MIN),
            startDateMax: $request->input(EventRequestConstants::START_DATE_MAX),
            finishDateMin: $request->input(EventRequestConstants::FINISH_DATE_MIN),
            finishDateMax: $request->input(EventRequestConstants::FINISH_DATE_MAX),
            startTimeMin: $request->input(EventRequestConstants::START_TIME_MIN),
            startTimeMax: $request->input(EventRequestConstants::START_TIME_MAX),
            finishTimeMin: $request->input(EventRequestConstants::FINISH_TIME_MIN),
            finishTimeMax: $request->input(EventRequestConstants::FINISH_TIME_MAX),
            ageFrom: $request->input(EventRequestConstants::AGE_FROM),
            ageTo: $request->input(EventRequestConstants::AGE_TO),
            ratingMin: $request->input(EventRequestConstants::RATING_MIN),
            ratingMax: $request->input(EventRequestConstants::RATING_MAX),
            authorId: $request->input(EventRequestConstants::AUTHOR_ID),
            parentId: $request->input(EventRequestConstants::PARENT_ID),
            cityId: $request->input(EventRequestConstants::CITY_ID),
            countryId: $request->input(EventRequestConstants::COUNTRY_ID),

        );
    }
}
