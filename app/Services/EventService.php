<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventConstants;
use App\Constants\DB\EventDBConstants;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\DTO\Photos\DeletePhotoDTO;
use App\DTO\Photos\DeletePhotosDTO;
use App\Repositories\Interfaces\EventFilterRepositoryInterface;
use App\Services\System\DataFormattersService;
use Illuminate\Support\Str;

class EventService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private PhotoService $photoService,
        private EventFilterRepositoryInterface $eventFilterRepository
    ) {
    }
    public function create(CreateEventDTO $createEventDTO): array
    {



        return $this->eventRepository->create([
            EventDBConstants::TITLE => $createEventDTO->getTitle(),
                // EventDBConstants::SLUG => $createEventDTO->getSlug(),
            EventDBConstants::LONGITUDE => $createEventDTO->getLongitude(),
            EventDBConstants::LATITUDE => $createEventDTO->getLatitude(),
            EventDBConstants::ADDITIONAL_AUTHOR => $createEventDTO->getAdditionalAuthors(),
            EventDBConstants::DESCRIPTION => $createEventDTO->getDescription(),
            EventDBConstants::SHORT_DESCRIPTION => $createEventDTO->getShortDescription(),
            EventDBConstants::MAIN_PHOTO => $createEventDTO->getMainPhoto(),
            EventDBConstants::PHOTOS => $createEventDTO->getPhotos(),
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
            EventDBConstants::AGE_FROM => $createEventDTO->getAgeFrom(),
            EventDBConstants::AGE_TO => $createEventDTO->getAgeTo(),
            EventDBConstants::CATEGORIES_IDS => $createEventDTO->getCategoriesIds(),
            EventDBConstants::TAGS_IDS => $createEventDTO->getTagsIds(),
            EventDBConstants::APPLIERS => $createEventDTO->getAppliers(),
            EventDBConstants::INTERESTARS => $createEventDTO->getInterestars(),
            EventDBConstants::RATING => $createEventDTO->getRating(),
            EventDBConstants::AUTHOR_ID => $createEventDTO->getAuthorId(),
            EventDBConstants::PARENT_ID => $createEventDTO->getParentId(),
            EventDBConstants::CITY_ID => $createEventDTO->getCityId(),
            EventDBConstants::COUNTRY_ID => $createEventDTO->getCountryId(),
        ]);

    }
    public function index(): array
    {
        $index = $this->eventRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Events is not found");
    }
    public function show(string $id): ?array
    {
        $show = $this->eventRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Event is not found");

    }
    public function delete(string $id): bool
    {
        return $this->eventRepository->delete($id);
    }
    public function update(array $data, string $id): array
    {
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
        $this->eventRepository->updateMainPhoto($id, '');
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
        $this->uploadMainPhoto($id, $photo);
        $this->uploadPhotos($id, $photos);
        return $this->eventRepository->show($id);
    }
    public function uploadMainPhoto(string $id, ?CreatePhotoDTO $photo): void
    {
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
    public function checkIsEventExistByEventId(string $eventId): bool
    {
        return $this->eventRepository->checkIsEventExistByEventId($eventId);
    }
    public function checkIsEventDoesNotExistByEventId(string $eventId): bool
    {
        return !$this->eventRepository->checkIsEventExistByEventId($eventId);
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
        return $this->eventRepository->getTopicById($id);
    }
    public function getAuthorIdByEventId(string $eventId): ?string
    {
        return $this->eventRepository->getAuthorIdByEventId($eventId);
    }
    public function getPhotoPathForDB(string $id, string $extension): ?string
    {
        return $this->photoService->getMainPhotoPath($id, $extension);
    }

    public function getMakePhotosDTO(?array $files, string $id): array
    {
        return $this->photoService->makePhotosDTO($files, $id);
    }
    private function getUnionPhotos(?array $photos): ?array
    {
        return $this->photoService->unionPhotos($photos);
    }
    public function getPhotoExtensionsForValidation(): string
    {
        return $this->photoService->makePhotoExtensionsForValidation();
    }


}
