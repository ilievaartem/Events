<?php

namespace App\DTO\Place;

use App\DTO\Contracts\DTOContract;

class UpdatePlaceDTO implements DTOContract
{
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly int    $communityId,
        private readonly int    $id,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCommunityId(): int
    {
        return $this->communityId;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
