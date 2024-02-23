<?php

namespace App\Http\Controllers;

use App\Constants\DB\EventDBConstants;
use App\DTO\Event\CreateEventDTO;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\Events\EventFilterRequest;
use App\Http\Requests\Events\EventUpdateRequest;
use App\Constants\Request\EventRequestConstants;
use App\DTO\Event\FilterEventDTO;
use App\Factory\FilterEventDTOFactory;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class EventController extends Controller
{

    public function __construct(private readonly EventService $eventService)
    {
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
    public function mailisearch(Request $request)
    {
        $city_id = $request->input(EventRequestConstants::CITY_ID);
        $country_id = $request->input(EventRequestConstants::COUNTRY_ID);
        $start_date_min = $request->input(EventRequestConstants::START_DATE_MIN);
        $start_date_max = $request->input(EventRequestConstants::START_DATE_MAX);

        // return Event::
        // ->wheres(EventDBConstants::START_DATE, '>' . $start_date_min);
        // index('events')
        // ->
        // search('', [
        //     'filter' => ['start_date >=' . $start_date_min]
        // ]);
        return Event::search()->query(function ($builder) use ($start_date_min, $city_id) {
            $builder->when($city_id != null, function ($query) use ($city_id) {
                return $query->where(EventDBConstants::CITY_ID, $city_id);
            });
            // $builder->where('start_date', '<', $start_date_min);

            // ->where('country_id', $country_id);
        })
            ->paginate();

        // ->when($city_id != null, function ($query) use ($city_id) {
        //     return $query->where(EventDBConstants::CITY_ID, $city_id);
        // })
        // ->when($country_id != null, function ($query) use ($country_id) {
        //     return $query->where('country_id', $country_id);
        // })
        // ->when($start_date_min != null, function ($query) use ($start_date_min) {
        //     return $query->where(EventDBConstants::START_DATE, '>', $start_date_min);

        // })
        // ->when($start_date_max != null, function ($query) use ($start_date_max) {
        //     return $query->where(EventDBConstants::START_DATE, '<', $start_date_max);
        // })
        // ->paginate(10);
        // ->toArray();
    }
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $createEventDTO = new CreateEventDTO(

            title: $request->input(EventRequestConstants::TITLE),
            // slug: $request->input(EventRequestConstants::SLUG),
            longitude: $request->input(EventRequestConstants::LONGITUDE),
            latitude: $request->input(EventRequestConstants::LATITUDE),
            additionalAuthors: $request->input(EventRequestConstants::ADDITIONAL_AUTHOR),
            description: $request->input(EventRequestConstants::DESCRIPTION),
            shortDescription: $request->input(EventRequestConstants::SHORT_DESCRIPTION),
            mainPhoto: $request->input(EventRequestConstants::MAIN_PHOTO),
            photos: $request->input(EventRequestConstants::PHOTOS),
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
            ageFrom: $request->input(EventRequestConstants::AGE_FROM),
            ageTo: $request->input(EventRequestConstants::AGE_TO),
            categoriesIds: $request->input(EventRequestConstants::CATEGORIES_IDS),
            tagsIds: $request->input(EventRequestConstants::TAGS_IDS),
            appliers: $request->input(EventRequestConstants::APPLIERS),
            interestars: $request->input(EventRequestConstants::INTERESTARS),
            rating: $request->input(EventRequestConstants::RATING),
            authorId: auth()->user()->getAuthIdentifier(),
            parentId: $request->input(EventRequestConstants::PARENT_ID),
            cityId: $request->input(EventRequestConstants::CITY_ID),
            countryId: $request->input(EventRequestConstants::COUNTRY_ID),
        );
        return response()->json($this->eventService->create($createEventDTO));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $title = $request->input(EventRequestConstants::TITLE);
        $slug = $request->input(EventRequestConstants::SLUG);
        $longitude = $request->input(EventRequestConstants::LONGITUDE);
        $latitude = $request->input(EventRequestConstants::LATITUDE);
        $additional_author = $request->input(EventRequestConstants::ADDITIONAL_AUTHOR);
        $description = $request->input(EventRequestConstants::DESCRIPTION);
        $street_name = $request->input(EventRequestConstants::STREET_NAME);
        $building = $request->input(EventRequestConstants::BUILDING);
        $place_name = $request->input(EventRequestConstants::PLACE_NAME);
        $corpus = $request->input(EventRequestConstants::CORPUS);
        $apartment = $request->input(EventRequestConstants::APARTMENT);
        $place_description = $request->input(EventRequestConstants::PLACE_DESCRIPTION);
        $start_date = $request->input(EventRequestConstants::START_DATE);
        $start_time = $request->input(EventRequestConstants::START_TIME);
        $finish_date = $request->input(EventRequestConstants::FINISH_DATE);
        $finish_time = $request->input(EventRequestConstants::FINISH_TIME);
        $age_from = $request->input(EventRequestConstants::AGE_FROM);
        $age_to = $request->input(EventRequestConstants::AGE_TO);
        $categories_ids = $request->input(EventRequestConstants::CATEGORIES_IDS);
        $tags_ids = $request->input(EventRequestConstants::TAGS_IDS);
        $appliers = $request->input(EventRequestConstants::APPLIERS);
        $interestars = $request->input(EventRequestConstants::INTERESTARS);
        $parent_id = $request->input(EventRequestConstants::PARENT_ID);
        $city_id = $request->input(EventRequestConstants::CITY_ID);
        $country_id = $request->input(EventRequestConstants::COUNTRY_ID);
        $event = [
            EventRequestConstants::TITLE => $title,
            EventRequestConstants::SLUG => $slug,
            EventRequestConstants::LONGITUDE => $longitude,
            EventRequestConstants::LATITUDE => $latitude,
            EventRequestConstants::ADDITIONAL_AUTHOR => $additional_author,
            EventRequestConstants::DESCRIPTION => $description,
                // EventRequestConstants::MAIN_PHOTO => $main_photo,
                // EventRequestConstants::PHOTOS => $photos,
            EventRequestConstants::STREET_NAME => $street_name,
            EventRequestConstants::BUILDING => $building,
            EventRequestConstants::PLACE_NAME => $place_name,
            EventRequestConstants::CORPUS => $corpus,
            EventRequestConstants::APARTMENT => $apartment,
            EventRequestConstants::PLACE_DESCRIPTION => $place_description,
            EventRequestConstants::START_DATE => $start_date,
            EventRequestConstants::START_TIME => $start_time,
            EventRequestConstants::FINISH_DATE => $finish_date,
            EventRequestConstants::FINISH_TIME => $finish_time,
            EventRequestConstants::AGE_FROM => $age_from,
            EventRequestConstants::AGE_TO => $age_to,
            EventRequestConstants::CATEGORIES_IDS => json_encode($categories_ids),
            EventRequestConstants::TAGS_IDS => json_encode($tags_ids),
            EventRequestConstants::APPLIERS => $appliers,
            EventRequestConstants::INTERESTARS => $interestars,
                // EventRequestConstants::RATING => $rating,
            EventRequestConstants::PARENT_ID => $parent_id,
            EventRequestConstants::CITY_ID => $city_id,
            EventRequestConstants::COUNTRY_ID => $country_id,
        ];
        return response()->json($this->eventService->update($event, $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->eventService->delete($id)]);


    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->eventService->show($id));
    }
    public function addPhotos(Request $request, string $id)
    {

        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            // $filePath = "/event/5/photos/kVUdh5oL.jpg";
            // Storage::disk('local')->delete($filePath);

            $formattedFiles = $this->eventService->formatFilesContent($id, $files);
            $mainPhoto = $request->file('main_photo');
            $mainPhotoExtension = $request->file('main_photo')->extension();
            return response()->json(
                $this->eventService->updatePhotos(
                    $id,
                    file_get_contents($mainPhoto),
                    $mainPhotoExtension,
                    $formattedFiles
                )
            );
        }
    }
}
