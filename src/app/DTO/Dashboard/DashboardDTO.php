<?php

namespace App\DTO\Dashboard;

use App\DTO\Contracts\DTOContract;

class DashboardDTO implements DTOContract
{
    public function __construct(
        private readonly ?array  $events,
        private readonly ?array $tags,
        private readonly ?array $users,
        private readonly ?array $categories,
    )
    {
    }
    public function getEvents(): ?array
    {
        return $this->events;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }
    public function getUsers(): ?array
    {
        return $this->users;
    }
    public function getCategories(): ?array
    {
        return $this->categories;
    }

}
