<?php

namespace App\Repositories;

use App\Constants\DB\UserDBConstants;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Query\Builder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param string $email
     * @return bool
     */
    public function checkUserExistByEmail(string $email): bool
    {
        return $this->model::query()->where(UserDBConstants::EMAIL, $email)->exists();
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getUserBannedStatus(string $id): ?string
    {
        return $this->model::query()->select([UserDBConstants::BANNED_AT])->find($id);
    }

    /**
     * @param string|null $name
     * @return int|null
     */
    public function searchByName(?string $name): ?int
    {
        return $this->model::where(UserDBConstants::NAME, $name)->find(UserDBConstants::ID);
    }

    /**
     * @param string $id
     * @param array $bannedAt
     * @return bool
     */
    public function updateBannedAt(string $id, array $bannedAt): bool
    {
        return $this->model::query()->where(UserDBConstants::ID, $id)->update($bannedAt);
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getPhotoPathById(string $id): ?string
    {
        return $this->model::query()->where(UserDBConstants::ID, $id)->value(UserDBConstants::AVATAR);
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getBannedAtById(string $id): ?string
    {
        return $this->model::query()->where(UserDBConstants::ID, $id)->value(UserDBConstants::BANNED_AT);
    }

    /**
     * @param string $id
     * @param string $photoPath
     * @return bool
     */
    public function updatePhoto(string $id, string $photoPath): bool
    {
        return $this->model::query()->where(UserDBConstants::ID, $id)->update([
            UserDBConstants::AVATAR => $photoPath,
        ]);
    }

    /**
     * @param string $email
     * @return array|null
     */
    public function getUserByEmail(string $email): ?array
    {
        return $this->model::query()->where(UserDBConstants::EMAIL, $email)->first()?->toArray();
    }

    /**
     * @param array $filter
     * @return array
     */
    public function index(?array $filter): array
    {
        return $this->model::query()
            ->when(!empty($filter['search']), function ($q) use ($filter) {
                return $q->where(function ($q) use ($filter) {
                    $q->where('name', 'like', '%' . $filter['search'] . '%')
                        ->orWhere('email', 'like', '%' . $filter['search'] . '%');
                });
            })
            ->when(!empty($filter['role']), function ($q) use ($filter) {
                return $q->where('role', $filter['role']);
            })
            ->when((!empty($filter['is_banned']) && $filter['is_banned'] == 'banned'), function ($q) use ($filter) {
                return $q->whereNotNull('banned_at');
            })
            ->when((!empty($filter['is_banned']) && $filter['is_banned'] == 'not_banned'), function ($q) use ($filter) {
                return $q->whereNull('banned_at');
            })
            ->when((!empty($filter['field']) && !empty($filter['direction'])), function ($q) use ($filter) {
                return $q->orderBy($filter['field'], $filter['direction']);
            })
            ->paginate()->toArray();
    }
}
