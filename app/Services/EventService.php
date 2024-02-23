<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventConstants;
use App\Constants\DB\EventDBConstants;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
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
    public function updatePhotos(string $id, ?string $mainPhoto, string $mainPhotoExtension, ?array $photos): array
    {
        $alreadyExistedPhotosPaths = $this->unionPhotos($this->eventRepository->getAllPhotosById($id));
        $mainPhotoPath = $this->photoService->getMainPhotoPath($id, $mainPhotoExtension);
        $photosPaths = $this->photoService->getPhotosPaths($id, $photos);
        $this->eventRepository->updatePhotos($id, $mainPhotoPath, $photosPaths);
        $this->photoService->loadPhotos($mainPhoto, $mainPhotoPath, $photos, );
        $this->photoService->deleteOldPhotos($alreadyExistedPhotosPaths);
        return $this->eventRepository->show($id);
    }

    public function formatFilesContent(string $id, array $files): array
    {
        foreach ($files as $file) {
            $formatPhotos[] = [
                'path' => "/event/" . $id . "/photos/" . Str::random(8) . "." . $file->extension(),
                'photo' => file_get_contents($file),
            ];
        }
        return $formatPhotos;
    }
    private function unionPhotos(array $photos): ?array
    {
        if (!empty($photos['main_photo']) && !empty($photos['photos'])) {

            return [
                ...$photos['photos'],
                $photos['main_photo'],

            ];
        }
        if (!empty($photos['main_photo'])) {
            return [
                $photos['main_photo']
            ];
        }
        if (!empty($photos['photos'])) {
            return $photos['photos'];
        }
        return [];

    }

}
