<?php

namespace App\DTO\Event;

use App\DTO\Contracts\DTOContract;

class CreateEventDTO implements DTOContract
{
    private ?string $additionalAuthorsStr;
    private ?string $appliersStr;
    private ?string $interestarsStr;
    public function __construct(
        private readonly string $title,
        private readonly float $longitude,
        private readonly float $latitude,
        private readonly ?array $additionalAuthors,
        private readonly string $description,
        private readonly string $shortDescription,
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
        private readonly string $age,
        private readonly array $categoriesIds,
        private readonly array $tagsIds,
        private readonly string $authorId,
        private readonly ?string $parentId,

        private readonly int $placeId,
    ) {
        $this->additionalAuthorsStr = json_encode($additionalAuthors);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

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

    public function getStreetName(): string
    {
        return $this->streetName;
    }
    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
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
    public function getAge(): string
    {
        return $this->age;
    }
    public function getTagsIds(): array
    {
        return $this->tagsIds;
    }
    public function getCategoriesIds(): array
    {
        return $this->categoriesIds;
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
