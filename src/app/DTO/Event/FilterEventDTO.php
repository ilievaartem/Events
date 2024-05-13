<?php

namespace App\DTO\Event;

use App\DTO\Contracts\DTOContract;

class FilterEventDTO implements DTOContract
{
    public function __construct(
        private ?string $field,
        private ?string $direction,
        private readonly ?string $phrase,
        private readonly ?float $longitude,
        private readonly ?float $latitude,
        private readonly ?int $geoRadius,
        private readonly ?array $searchBy,
        private readonly ?string $startDateMin,
        private readonly ?string $startDateMax,
        private readonly ?string $startDate,
        private readonly ?string $finishDate,
        private readonly ?string $finishDateMin,
        private readonly ?string $finishDateMax,
        private readonly ?string $startTimeMin,
        private readonly ?string $startTimeMax,
        private readonly ?string $finishTimeMin,
        private readonly ?string $finishTimeMax,
        private readonly ?string $age,
        private readonly ?float $ratingMin,
        private readonly ?float $ratingMax,
        private readonly ?string $authorId,
        private readonly ?string $parentId,
        private readonly ?int $countryId,
        private readonly ?int $regionId,
        private readonly ?int $communityId,
        private readonly ?int $placeId,
        private readonly ?string $search,
    ) {

    }
    public function getField(): ?string
    {
        return $this->field;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }
    public function getPhrase(): ?string
    {
        return $this->phrase;
    }
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
    public function getGeoRadius(): ?int
    {
        return $this->geoRadius;
    }
    public function getSearchBy(): ?array
    {
        return $this->searchBy;
    }
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }
    public function getStartDateMin(): ?string
    {
        return $this->startDateMin;
    }
    public function getStartDateMinUnix(): ?int
    {
        return strtotime($this->startDateMin);
    }
    public function getStartDateMax(): ?string
    {
        return $this->startDateMax;
    }
    public function getStartDateMaxUnix(): ?int
    {
        return strtotime($this->startDateMax);
    }
    public function getFinishDate(): ?string
    {
        return $this->finishDate;
    }
    public function getFinishDateMin(): ?string
    {
        return $this->finishDateMin;
    }
    public function getFinishDateMinUnix(): ?int
    {
        return strtotime($this->finishDateMin);
    }
    public function getFinishDateMax(): ?string
    {
        return $this->finishDateMax;
    }
    public function getFinishDateMaxUnix(): ?int
    {
        return strtotime($this->finishDateMax);
    }

    public function getStartTimeMin(): ?string
    {
        return $this->startTimeMin;
    }
    public function getStartTimeMinUnix(): ?int
    {
        return strtotime($this->startTimeMin);
    }
    public function getStartTimeMax(): ?string
    {
        return $this->startTimeMax;
    }
    public function getStartTimeMaxUnix(): ?int
    {
        return strtotime($this->startTimeMax);
    }
    public function getFinishTimeMin(): ?string
    {
        return $this->finishTimeMin;
    }
    public function getFinishTimeMinUnix(): ?int
    {
        return strtotime($this->finishTimeMin);
    }
    public function getFinishTimeMax(): ?string
    {
        return $this->finishTimeMax;
    }
    public function getFinishTimeMaxUnix(): ?int
    {
        return strtotime($this->finishTimeMax);
    }
    public function getAge(): ?string
    {
        return $this->age;
    }

    public function getRatingMin(): ?float
    {
        return $this->ratingMin;
    }
    public function getRatingMax(): ?float
    {
        return $this->ratingMax;
    }
    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }
    public function getParentId(): ?string
    {
        return $this->parentId;
    }
    public function getRegionId(): ?int
    {
        return $this->regionId;
    }
    public function getCommunityId(): ?int
    {
        return $this->communityId;
    }
    public function getPlaceId(): ?int
    {
        return $this->placeId;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }
}
