<?php

namespace App\Repositories;

use App\Constants\DB\EventDBConstants;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Constants\DB\UserDBConstants;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function searchByName(?string $name): ?int
    {
        return User::where(UserDBConstants::NAME, $name)->find(UserDBConstants::ID);
    }
    public function updateBannedAt(string $id, array $bannedAt): bool
    {
        return User::query()->where(UserDBConstants::ID, $id)->update($bannedAt);
    }


    public function getPhotoPathById(string $id): ?string
    {
        return User::query()->where(UserDBConstants::ID, $id)->value(UserDBConstants::AVATAR);
    }
    public function getBannedAtById(string $id): ?string
    {
        return User::query()->where(UserDBConstants::ID, $id)->value(UserDBConstants::BANNED_AT);
    }
    public function updatePhoto(string $id, string $photoPath): bool
    {
        return User::query()->where(UserDBConstants::ID, $id)->update([
            UserDBConstants::AVATAR => $photoPath,
        ]);
    }


}
