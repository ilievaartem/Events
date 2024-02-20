<?php

namespace App\DTO\Event;

use App\DTO\Contracts\DTOContract;

class CreateEventDTO implements DTOContract
{
    private string $categoriesIdsStr;
    private ?string $additionalAuthorsStr;
    private ?string $tagsIdsStr;
    private ?string $photosStr;
    private ?string $appliersStr;
    private ?string $interestarsStr;
    public function __construct(
        private readonly string $title,
        // private readonly string $slug,
        private readonly float $longitude,
        private readonly float $latitude,
        private readonly ?array $additionalAuthors,
        private readonly string $description,
        private readonly string $shortDescription,
        private readonly ?string $mainPhoto,
        private readonly ?array $photos,
        private readonly string $streetName,
        private readonly ?string $building,
        private readonly ?string $placeName,
        private readonly ?string $corpus,
        private readonly ?string $apartment,
        private readonly string $placeDescription,
        private readonly string $startDate,
        private readonly string $startTime,
        private readonly string $finishDate,
        private readonly string $finishTime,
        private readonly int $ageFrom,
        private readonly int $ageTo,
        private readonly array $categoriesIds,
        private readonly ?array $tagsIds,
        private readonly ?array $appliers,
        private readonly ?array $interestars,
        private readonly ?float $rating,
        private readonly string $authorId,
        private readonly ?string $parentId,
        private readonly int $cityId,
        private readonly int $countryId,
    ) {
        $this->categoriesIdsStr = json_encode($categoriesIds);
        $this->additionalAuthorsStr = json_encode($additionalAuthors);
        $this->photosStr = json_encode($photos);
        $this->tagsIdsStr = json_encode($tagsIds);
        $this->appliersStr = json_encode($appliers);
        $this->interestarsStr = json_encode($interestars);
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    // public function getSlug(): string
    // {
    //     return $this->slug;
    // }
    public function getAdditionalAuthors(): ?string
    {
        return $this->additionalAuthorsStr;
    }
    public function getLongitude(): float
    {
        return $this->longitude;
    }
    public function getLatitude(): float
    {
        return $this->latitude;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }
    public function getMainPhoto(): ?string
    {
        return $this->mainPhoto;
    }
    public function getPhotos(): ?string
    {
        return $this->photosStr;
    }
    public function getStreetName(): string
    {
        return $this->streetName;
    }
    public function getBuilding(): ?string
    {
        return $this->building;
    }
    public function getCityId(): int
    {
        return $this->cityId;
    }
    public function getCountryId(): int
    {
        return $this->countryId;
    }
    public function getPlaceName(): ?string
    {
        return $this->placeName;
    }
    public function getCorpus(): ?string
    {
        return $this->corpus;
    }


    public function getApartment(): ?string
    {
        return $this->apartment;
    }
    public function getPlaceDescription(): string
    {
        return $this->placeDescription;
    }
    public function getStartDate(): string
    {
        return $this->startDate;
    }
    public function getStartTime(): string
    {
        return $this->startTime;
    }
    public function getFinishDate(): string
    {
        return $this->finishDate;
    }
    public function getFinishTime(): string
    {
        return $this->finishTime;
    }
    public function getAgeFrom(): int
    {
        return $this->ageFrom;
    }
    public function getAgeTo(): int
    {
        return $this->ageTo;
    }
    public function getTagsIds(): ?string
    {
        return $this->tagsIdsStr;
    }
    public function getAppliers(): ?string
    {
        return $this->appliersStr;
    }
    public function getInterestars(): ?string
    {
        return $this->interestarsStr;
    }
    public function getCategoriesIds(): string
    {
        return $this->categoriesIdsStr;
    }
    public function getRating(): ?float
    {
        return $this->rating;
    }
    public function getAuthorId(): string
    {
        return $this->authorId;
    }
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

}
