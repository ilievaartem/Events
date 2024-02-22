<?php

namespace App\DTO\Event;

use App\DTO\Contracts\DTOContract;

class FilterEventDTO implements DTOContract
{
    public function __construct(
        private readonly ?string $phrase,
        private readonly ?float $longitude,
        private readonly ?float $latitude,
        private readonly ?array $searchBy,
        private readonly ?string $startDateMin,
        private readonly ?string $startDateMax,
        private readonly ?string $finishDateMin,
        private readonly ?string $finishDateMax,
        private readonly ?string $startTimeMin,
        private readonly ?string $startTimeMax,
        private readonly ?string $finishTimeMin,
        private readonly ?string $finishTimeMax,
        private readonly ?int $ageFrom,
        private readonly ?int $ageTo,
        private readonly ?float $ratingMin,
        private readonly ?float $ratingMax,
        private readonly ?string $authorId,
        private readonly ?string $parentId,
        private readonly ?int $cityId,
        private readonly ?int $countryId,
    ) {

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
    public function getSearchBy(): ?array
    {
        return $this->searchBy;
    }
    public function getStartDateMin(): ?string
    {
        return $this->startDateMin;
    }
    public function getStartDateMax(): ?string
    {
        return $this->startDateMax;
    }
    public function getFinishDateMin(): ?string
    {
        return $this->finishDateMin;
    }
    public function getFinishDateMax(): ?string
    {
        return $this->finishDateMax;
    }

    public function getStartTimeMin(): ?string
    {
        return $this->startTimeMin;
    }
    public function getStartTimeMax(): ?string
    {
        return $this->startTimeMax;
    }
    public function getFinishTimeMin(): ?string
    {
        return $this->finishTimeMin;
    }
    public function getFinishTimeMax(): ?string
    {
        return $this->finishTimeMax;
    }
    public function getAgeFrom(): ?int
    {
        return $this->ageFrom;
    }
    public function getAgeTo(): ?int
    {
        return $this->ageTo;
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
    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

}
