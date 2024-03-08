<?php

namespace App\Repositories\Interfaces;

interface ApplierRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIsApplierExist(string $eventId, string $userId): bool;
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string;

}
