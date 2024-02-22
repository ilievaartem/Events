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
    private const PER_PAGE = 10;

    public function searchByName(?string $name): ?int
    {
        return User::where(UserDBConstants::NAME, $name)->find(UserDBConstants::ID);
    }
    public function getPhotoPathById(string $id): string
    {
        return User::query()->where(UserDBConstants::ID, $id)->value(UserDBConstants::AVATAR);
    }
    public function updatePhoto(string $id, string $photoPath): bool
    {
        return User::query()->where(UserDBConstants::ID, $id)->update([
            UserDBConstants::AVATAR => $photoPath,
        ]);
    }
    public function userEvents(string $userId): array
    {

        return Event::where(EventDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();

    }

}
