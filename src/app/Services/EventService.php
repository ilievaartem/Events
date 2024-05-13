<?php

namespace App\Services;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CommonDB\CommonDBConstants;
use App\Constants\DB\CommunityDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\EventConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\PlaceDBConstants;
use App\Constants\DB\RegionDBConstants;
use App\Constants\DB\TagDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Constants\File\PathsConstants;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use App\DTO\Event\UpdateEventDTO;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\DTO\Photos\DeletePhotosDTO;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventFilterRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\System\CRUDService;


class EventService extends CrudService
{
    public const EVENTS_IDS = 'events_ids';

    public function __construct(
        EventRepositoryInterface                        $repository,
        private readonly PhotoService                   $photoService,
        private readonly UserService                    $userService,
        private readonly EventTagService                $eventTagService,
        private readonly CategoryEventService           $categoryEventService,
        private readonly EventFilterRepositoryInterface $eventFilterRepository,
        private readonly CountryService                 $countryService,
        private readonly RegionService                  $regionService,
        private readonly CommunityService               $communityService,
        private readonly PlaceService                   $placeService,
        private readonly TagService                     $tagService,
        private readonly CategoryService                $categoryService,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param UpdateEventDTO $updateEventDTO
     * @param array $geo
     * @return array
     */
    private function formatUpdateEventDTOToRecord(UpdateEventDTO $updateEventDTO, array $geo): array
    {
        return [
            EventDBConstants::TITLE => $updateEventDTO->getTitle(),
            EventDBConstants::LONGITUDE => $updateEventDTO->getLongitude(),
            EventDBConstants::LATITUDE => $updateEventDTO->getLatitude(),
            EventDBConstants::ADDITIONAL_AUTHOR => $updateEventDTO->getAdditionalAuthors(),
            EventDBConstants::DESCRIPTION => $updateEventDTO->getDescription(),
            EventDBConstants::SHORT_DESCRIPTION => $updateEventDTO->getShortDescription(),
            EventDBConstants::STREET_NAME => $updateEventDTO->getStreetName(),
            EventDBConstants::BUILDING => $updateEventDTO->getBuilding(),
            EventDBConstants::PLACE_NAME => $updateEventDTO->getPlaceName(),
            EventDBConstants::CORPUS => $updateEventDTO->getCorpus(),
            EventDBConstants::APARTMENT => $updateEventDTO->getApartment(),
            EventDBConstants::PLACE_DESCRIPTION => $updateEventDTO->getPlaceDescription(),
            EventDBConstants::START_DATE => $updateEventDTO->getStartDate(),
            EventDBConstants::START_TIME => $updateEventDTO->getStartTime(),
            EventDBConstants::FINISH_DATE => $updateEventDTO->getFinishDate(),
            EventDBConstants::FINISH_TIME => $updateEventDTO->getFinishTime(),
            EventDBConstants::AGE => $updateEventDTO->getAge(),
            EventDBConstants::PARENT_ID => $updateEventDTO->getParentId(),
            EventDBConstants::COUNTRY_ID => $geo[RegionDBConstants::COUNTRY_ID],
            EventDBConstants::REGION_ID => $geo[CommunityDBConstants::REGION_ID],
            EventDBConstants::COMMUNITY_ID => $geo[PlaceDBConstants::COMMUNITY_ID],
            EventDBConstants::PLACE_ID => $updateEventDTO->getPlaceId(),
        ];
    }

    /**
     * @param CreateEventDTO $createEventDTO
     * @param array $geo
     * @return array
     */
    private function formatCreateEventDTOToRecord(CreateEventDTO $createEventDTO, array $geo): array
    {
        return [
            EventDBConstants::TITLE => $createEventDTO->getTitle(),
            EventDBConstants::LONGITUDE => $createEventDTO->getLongitude(),
            EventDBConstants::LATITUDE => $createEventDTO->getLatitude(),
            EventDBConstants::ADDITIONAL_AUTHOR => $createEventDTO->getAdditionalAuthors(),
            EventDBConstants::DESCRIPTION => $createEventDTO->getDescription(),
            EventDBConstants::SHORT_DESCRIPTION => $createEventDTO->getShortDescription(),
            EventDBConstants::STREET_NAME => $createEventDTO->getStreetName(),
            EventDBConstants::BUILDING => $createEventDTO->getBuilding(),
            EventDBConstants::PLACE_NAME => $createEventDTO->getPlaceName(),
            EventDBConstants::CORPUS => $createEventDTO->getCorpus(),
            EventDBConstants::APARTMENT => $createEventDTO->getApartment(),
            EventDBConstants::PLACE_DESCRIPTION => $createEventDTO->getPlaceDescription(),
            EventDBConstants::START_DATE => $createEventDTO->getStartDate(),
            EventDBConstants::START_TIME => $createEventDTO->getStartTime(),
            EventDBConstants::FINISH_DATE => $createEventDTO->getFinishDate(),
            EventDBConstants::FINISH_TIME => $createEventDTO->getFinishTime(),
            EventDBConstants::AGE => $createEventDTO->getAge(),
            EventDBConstants::AUTHOR_ID => $createEventDTO->getAuthorId(),
            EventDBConstants::PARENT_ID => $createEventDTO->getParentId(),
            EventDBConstants::COUNTRY_ID => $geo[RegionDBConstants::COUNTRY_ID],
            EventDBConstants::REGION_ID => $geo[CommunityDBConstants::REGION_ID],
            EventDBConstants::COMMUNITY_ID => $geo[PlaceDBConstants::COMMUNITY_ID],
            EventDBConstants::PLACE_ID => $createEventDTO->getPlaceId(),
        ];
    }

    /**
     * @param CreateEventDTO $createEventDTO
     * @return array
     * @throws NotFoundException
     */
    public function create(CreateEventDTO $createEventDTO): array
    {
        $this->placeService->checkIsExist($createEventDTO->getPlaceId());
        $geo = $this->placeService->getGeoByPlace($createEventDTO->getPlaceId());
        $event = $this->repository->create($this->formatCreateEventDTOToRecord($createEventDTO, $geo));
        $eventId = $event[EventDBConstants::ID];
        $this->repository->addTagsIds($eventId, $createEventDTO->getTagsIds());
        $this->repository->addCategoriesIds($eventId, $createEventDTO->getCategoriesIds());
        return $event;

    }

    /**
     * @param int|string $id
     * @return array
     * @throws NotFoundException
     */
    public function show(int|string $id): array
    {
        $this->checkIsExist($id);
        return $this->repository->getEventWithOtherData($id);
    }

    /**
     * @return array
     */
    public function getTables(): array
    {
        $users = $this->userService->getAll(UserDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $countries = $this->countryService->getAll(CountryDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $regions = $this->regionService->getAll(RegionDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $communities = $this->communityService->getAll(CommunityDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $places = $this->placeService->showEventEdit();
        $tags = $this->tagService->getAll(TagDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $categories = $this->categoryService->getAll(CategoryDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);

        return [
            'users' => $users,
            'countries' => $countries,
            'regions' => $regions,
            'communities' => $communities,
            'places' => $places,
            'tags' => $tags,
            'categories' => $categories
        ];
    }

    /**
     * @param string $id
     * @param string|null $place
     * @return array
     * @throws NotFoundException
     */
    private function formatEventForSimilar(string $id, ?string $place): array
    {
        $event = $this->repository->getInfoForSimilar($id);
        $tagsIds = [];
        $categoriesIds = [];
        $eventsByCategoriesFormatted = [];
        $eventsByTagsFormatted = [];
        foreach ($event['tags'] as $tag) {
            $tagsIds[] = $tag['id'];
        }
        foreach ($event['categories'] as $category) {
            $categoriesIds[] = $category['id'];
        }
        $eventsIdByTags = $this->eventTagService->getEventsIdByTags($tagsIds);
        foreach ($eventsIdByTags as $tag) {
            $eventsByTagsFormatted[] = $tag['event_id'];
        }
        $eventsIdByCategories = $this->categoryEventService->getEventsIdByCategories($categoriesIds);
        foreach ($eventsIdByCategories as $category) {
            $eventsByCategoriesFormatted[] = $category['event_id'];
        }
        if ($place != null) {
            $this->placeService->checkIsExistByName($place);

        }
        return [
            EventDBConstants::PLACE_ID => $place,
            self::EVENTS_IDS => array_unique(array_merge($eventsByTagsFormatted, $eventsByCategoriesFormatted)),
        ];

    }

    /**
     * @param string $id
     * @param string|null $place
     * @return array
     * @throws NotFoundException
     */
    public function similar(string $id, ?string $place): array
    {
        $this->checkIsExist($id);
        return $this->repository->getSimilarEvents($this->formatEventForSimilar($id, $place));
    }

    /**
     * @param string $id
     * @return array
     */
    public function getEventsByAuthorId(string $id): array
    {
        return $this->repository->getEventsByAuthorID($id);
    }

    /**
     * @param UpdateEventDTO $updateEventDTO
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function update(UpdateEventDTO $updateEventDTO, string $id): array
    {
        $this->checkIsExist($id);
        $this->placeService->checkIsExist($updateEventDTO->getPlaceId());
        $geo = $this->placeService->getGeoByPlace($updateEventDTO->getPlaceId());
        $this->repository->update($this->formatUpdateEventDTOToRecord($updateEventDTO, $geo), $id);
        $this->repository->addTagsIds($id, $updateEventDTO->getTagsIds());
        $this->repository->addCategoriesIds($id, $updateEventDTO->getCategoriesIds());
        return $this->repository->show($id);
    }

    /**
     * @param string|null $title
     * @param string|null $description
     * @return array|null
     */
    public function searchEvent(?string $title, ?string $description): ?array
    {
        return $this->repository->searchEvent($title, $description);
    }

    /**
     * @param FilterEventDTO $filterEventDTO
     * @return array|null
     */
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array
    {
        return $this->eventFilterRepository->filterEvents($filterEventDTO);
    }

    /**
     * @param string $id
     * @param DeletePhotosDTO $photos
     * @return bool
     */
    public function deletePhotos(string $id, DeletePhotosDTO $photos): bool
    {

        $oldPhotosPaths = $this->repository->getEventPhotosById($id);
        if ($oldPhotosPaths === null) {
            return true;
        }
        $this->repository->updatePhotos(
            $id,
            $this->getPhotosPathForUpdate($oldPhotosPaths, $photos->getPhotos()),
        );
        return $this->photoService->deleteOldPhotos($photos->getPhotos());
    }

    /**
     * @param string $id
     * @return bool
     */
    public function deleteMainPhoto(string $id): bool
    {
        $oldMainPhotoPath = $this->repository->getEventMainPhotoById($id);
        if ($oldMainPhotoPath === null) {
            return true;
        }
        $this->repository->updateMainPhoto($id, null);
        return $this->photoService->deleteOldPhoto($oldMainPhotoPath);
    }

    /**
     * @param array $photosFromDB
     * @param array $photoToDelete
     * @return array
     */
    private function getPhotosPathForUpdate(array $photosFromDB, array $photoToDelete): array
    {
        $photosKeysToUpdate = array_diff_key(
            array_flip(array_values($photosFromDB[EventDBConstants::PHOTOS])),
            array_flip($photoToDelete),
        );
        return array_keys($photosKeysToUpdate);
    }

    /**
     * @param string $id
     * @param CreatePhotoDTO|null $photo
     * @param CreatePhotosDTO|null $photos
     * @return array
     * @throws NotFoundException
     */
    public function updatePhotos(string $id, ?CreatePhotoDTO $photo, ?CreatePhotosDTO $photos)
    {
        $this->checkIsExist($id);

        $this->uploadMainPhoto($id, $photo);
        $this->uploadPhotos($id, $photos);
        return $this->repository->show($id);
    }

    /**
     * @param string $id
     * @param CreatePhotoDTO|null $photo
     * @return void
     * @throws NotFoundException
     */
    public function uploadMainPhoto(string $id, ?CreatePhotoDTO $photo): void
    {
        $this->checkIsExist($id);

        if ($photo == null) {
            return;
        }

        $mainPhotoPath = $photo->getPathForDB();
        $this->repository->updateMainPhoto($id, $mainPhotoPath);
        $photoContent = $this->photoService->getPhotoContent($photo->getCurrentPath());
        $this->photoService->storagePhoto($mainPhotoPath, $photoContent);

    }

    /**
     * @param string $id
     * @param CreatePhotosDTO|null $photos
     * @return void
     * @throws NotFoundException
     */
    public function uploadPhotos(string $id, ?CreatePhotosDTO $photos): void
    {
        $this->checkIsExist($id);

        if ($photos == null) {
            return;
        }
        $oldPhotosPaths = $this->repository->getEventPhotosById($id);
        $photosPaths = $this->photoService->getPhotosPaths($photos);
        $PhotosPathsForUpdate = $photosPaths;

        if ($oldPhotosPaths != null) {
            $PhotosPathsForUpdate = array_merge($oldPhotosPaths[EventDBConstants::PHOTOS], $photosPaths);
        }
        $this->repository->updatePhotos($id, $PhotosPathsForUpdate);
        $photoContentAndPath = $this->photoService->getPhotosContentAndPath($photos);
        $this->photoService->storagePhotos($photoContentAndPath);

    }

    /**
     * @param string $id
     * @param string $userId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsEventHasCurrentAuthorId($id, $userId) == false) {
            throw new ForbiddenException("Current user do not create that event");
        }
    }

    /**
     * @param string $id
     * @param string $userId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function checkIsNotAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsEventHasCurrentAuthorId($id, $userId) == true) {
            throw new ForbiddenException("Current user create that event");
        }
    }

    /**
     * @param string $eventId
     * @return bool
     */
    public function checkIsEventExistByEventId(string $eventId): bool
    {
        return $this->repository->checkIsExist($eventId);
    }

    /**
     * @param string $eventId
     * @return bool
     */
    public function checkIsEventDoesNotExistByEventId(string $eventId): bool
    {
        return !$this->repository->checkIsExist($eventId);
    }

    /**
     * @param string $eventId
     * @param string $authorId
     * @return bool
     */
    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->repository->checkIsEventHasCurrentAuthorId($eventId, $authorId);
    }

    /**
     * @param string $eventId
     * @param string $authorId
     * @return bool
     */
    public function checkIsEventHasNotCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return !$this->repository->checkIsEventHasCurrentAuthorId($eventId, $authorId);
    }

    /**
     * @param string $id
     * @return string|null
     * @throws NotFoundException
     */
    public function getTopicById(string $id): ?string
    {
        $this->checkIsExist($id);

        return $this->repository->getTopicById($id);
    }

    /**
     * @param string $eventId
     * @return string|null
     * @throws NotFoundException
     */
    public function getAuthorIdByEventId(string $eventId): ?string
    {
        $this->checkIsExist($eventId);

        return $this->repository->getAuthorIdByEventId($eventId);
    }

    /**
     * @param string $id
     * @param string $extension
     * @return string|null
     * @throws NotFoundException
     */
    public function getMainPhotoPathForDB(string $id, string $extension): ?string
    {
        $this->checkIsExist($id);

        return $this->photoService->makePhotoDirectoryNameForEvent($id, $extension, PathsConstants::ENTITY_EVENT);
    }

    /**
     * @param array|null $files
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function getPhotosDTO(?array $files, string $id): array
    {
        $this->checkIsExist($id);
        return $this->photoService->makePhotosDTO($files, $id, PathsConstants::ENTITY_EVENT);
    }

    /**
     * @return string
     */
    public function getPhotoExtensionsForValidation(): string
    {
        return $this->photoService->makePhotoExtensionsForValidation();
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Event is not found");

        }
    }
}
