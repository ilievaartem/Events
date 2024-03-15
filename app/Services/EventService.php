<?php

namespace App\Services;

use App\Constants\DB\CityDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\File\PathsConstants;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\DTO\Photos\DeletePhotoDTO;
use App\DTO\Photos\DeletePhotosDTO;
use App\Exceptions\AuthException;
use App\Exceptions\ForbiddenException;
use App\Models\Event;
use App\Repositories\Interfaces\EventFilterRepositoryInterface;
use App\Services\System\DataFormattersService;
use Illuminate\Support\Str;

class EventService
{
    public const EVENTS_IDS = 'events_ids';
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private PhotoService $photoService,
        private UserService $userService,
        private EventTagService $eventTagService,
        private CategoryEventService $categoryEventService,
        private EventFilterRepositoryInterface $eventFilterRepository
    ) {
    }
    public function create(CreateEventDTO $createEventDTO): array
    {
        $event = $this->eventRepository->create([
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
            EventDBConstants::APPLIERS => $createEventDTO->getAppliers(),
            EventDBConstants::INTERESTARS => $createEventDTO->getInterestars(),
            EventDBConstants::RATING => $createEventDTO->getRating(),
            EventDBConstants::AUTHOR_ID => $createEventDTO->getAuthorId(),
            EventDBConstants::PARENT_ID => $createEventDTO->getParentId(),
            EventDBConstants::CITY_ID => $createEventDTO->getCityId(),
            EventDBConstants::COUNTRY_ID => $createEventDTO->getCountryId(),
        ]);
        $eventId = $event[EventDBConstants::ID];
        $this->eventRepository->addTagsIds($eventId, $createEventDTO->getTagsIds());
        $this->eventRepository->addCategoriesIds($eventId, $createEventDTO->getCategoriesIds());
        return $event;

    }
    public function index(): array
    {
        $index = $this->eventRepository->getEventsWithRelations();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Events is not found");
    }
    public function show(string $id): array
    {
        $this->checkIsExist($id);
        return $this->eventRepository->getEventWithRelations($id);
    }
    public function delete(string $id): bool
    {
        return $this->eventRepository->delete($id);
    }

    private function formatEventForSimilar(string $id, ?string $city): array
    {
        $event = $this->eventRepository->getInfoForSimilar($id);
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

        if ($city != null) {
            // $city = $this->cityService->getIdByName($city);
        }
        return [
            EventDBConstants::CITY_ID => $city,
            self::EVENTS_IDS => array_unique(array_merge($eventsByTagsFormatted, $eventsByCategoriesFormatted)),
        ];

    }
    public function similar(string $id, ?string $city): array
    {
        $this->checkIsExist($id);
        return $this->eventRepository->getSimilarEvents($this->formatEventForSimilar($id, $city));
    }
    public function getEventsByAuthorId(string $id): array
    {
        return $this->eventRepository->getEventsByAuthorID($id);
    }
    public function update(array $data, string $id): array
    {
        $this->checkIsExist($id);

        $this->eventRepository->update($data, $id);
        return $this->eventRepository->show($id);
    }
    public function searchEvent(?string $title, ?string $description): ?array
    {
        return $this->eventRepository->searchEvent($title, $description);
    }
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array
    {
        return $this->eventFilterRepository->filterEvents($filterEventDTO);
    }
    public function deletePhotos(string $id, DeletePhotosDTO $photos): bool
    {

        $oldPhotosPaths = $this->eventRepository->getEventPhotosById($id);
        if ($oldPhotosPaths === null) {
            return true;
        }
        $this->eventRepository->updatePhotos(
            $id,
            $this->getPhotosPathForUpdate($oldPhotosPaths, $photos->getPhotos()),
        );
        return $this->photoService->deleteOldPhotos($photos->getPhotos());
    }
    public function deleteMainPhoto(string $id): bool
    {
        $oldMainPhotoPath = $this->eventRepository->getEventMainPhotoById($id);
        if ($oldMainPhotoPath === null) {
            return true;
        }
        $this->eventRepository->updateMainPhoto($id, null);
        return $this->photoService->deleteOldPhoto($oldMainPhotoPath);
    }

    private function getPhotosPathForUpdate(array $photosFromDB, array $photoToDelete): array
    {


        $photosKeysToUpdate = array_diff_key(
            array_flip(array_values($photosFromDB[EventDBConstants::PHOTOS])),
            array_flip($photoToDelete),
        );
        return array_keys($photosKeysToUpdate);
    }


    public function updatePhotos(string $id, ?CreatePhotoDTO $photo, ?CreatePhotosDTO $photos)
    {
        $this->checkIsExist($id);

        $this->uploadMainPhoto($id, $photo);
        $this->uploadPhotos($id, $photos);
        return $this->eventRepository->show($id);
    }
    public function uploadMainPhoto(string $id, ?CreatePhotoDTO $photo): void
    {
        $this->checkIsExist($id);

        if ($photo == null) {
            return;
        }
        $mainPhotoPath = $photo->getPathForDB();
        $this->eventRepository->updateMainPhoto($id, $mainPhotoPath);
        $photoContent = $this->photoService->getPhotoContentForEvent($photo);
        $this->photoService->storagePhoto($mainPhotoPath, $photoContent);

    }
    public function uploadPhotos(string $id, ?CreatePhotosDTO $photos): void
    {
        $this->checkIsExist($id);

        if ($photos == null) {
            return;
        }
        $oldPhotosPaths = $this->eventRepository->getEventPhotosById($id);
        $photosPaths = $this->photoService->getPhotosPaths($photos);
        $PhotosPathsForUpdate = $photosPaths;

        if ($oldPhotosPaths != null) {
            $PhotosPathsForUpdate = array_merge($oldPhotosPaths[EventDBConstants::PHOTOS], $photosPaths);
        }
        $this->eventRepository->updatePhotos($id, $PhotosPathsForUpdate);
        $photoContentAndPath = $this->photoService->getPhotosContentAndPath($photos);
        $this->photoService->storagePhotos($photoContentAndPath);

    }
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsEventHasCurrentAuthorId($id, $userId) == false) {
            throw new ForbiddenException("Current user do not create that event");
        }
    }
    public function checkIsNotAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsEventHasCurrentAuthorId($id, $userId) == true) {
            throw new ForbiddenException("Current user create that event");
        }
    }
    public function checkIsEventExistByEventId(string $eventId): bool
    {
        return $this->eventRepository->checkIsExist($eventId);
    }
    public function checkIsEventDoesNotExistByEventId(string $eventId): bool
    {
        return !$this->eventRepository->checkIsExist($eventId);
    }
    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->eventRepository->checkIsEventHasCurrentAuthorId($eventId, $authorId);
    }
    public function checkIsEventHasNotCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return !$this->eventRepository->checkIsEventHasCurrentAuthorId($eventId, $authorId);
    }
    public function getTopicById(string $id): ?string
    {
        $this->checkIsExist($id);

        return $this->eventRepository->getTopicById($id);
    }
    public function getAuthorIdByEventId(string $eventId): ?string
    {
        $this->checkIsExist($eventId);

        return $this->eventRepository->getAuthorIdByEventId($eventId);
    }
    public function getMainPhotoPathForDB(string $id, string $extension): ?string
    {
        $this->checkIsExist($id);

        return $this->photoService->makePhotoDirectoryNameForEvent($id, $extension, PathsConstants::ENTITY_EVENT);
    }

    public function getPhotosDTO(?array $files, string $id): array
    {
        $this->checkIsExist($id);
        return $this->photoService->makePhotosDTO($files, $id, PathsConstants::ENTITY_EVENT);
    }

    public function getPhotoExtensionsForValidation(): string
    {
        return $this->photoService->makePhotoExtensionsForValidation();
    }

    public function checkIsExist(string $id): void
    {
        if ($this->eventRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Event is not found");

        }
    }
}
