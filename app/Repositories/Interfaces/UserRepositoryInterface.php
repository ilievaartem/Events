<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{


    public function getPhotoPathById(string $id): ?string;
    public function updatePhoto(string $id, string $photoPath): bool;
    public function getBannedAtById(string $id): ?string;
    public function getUserBannedStatus(string $id): ?string;
    public function updateBannedAt(string $id, array $bannedAt): bool;
    public function searchByName(string $name): ?int;
}
