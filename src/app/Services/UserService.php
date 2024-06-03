<?php

namespace App\Services;

use App\Constants\DB\UserDBConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Jobs\LoadUserAvatarJob;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\System\CRUDService;
use Illuminate\Support\Facades\Hash;

class UserService extends CRUDService
{
    public function __construct(
        UserRepositoryInterface       $repository,
        private readonly PhotoService $photoService,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getUsersCountsByYearAndMonths(int $year, array $months): array
    {
        return $this->repository->getUsersCountsByYearAndMonths($year, $months);
    }

    /**
     * @param string $password
     * @return string
     */
    private function passwordHash(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @param CreateUserDTO $createUserDTO
     * @return array
     */
    private function formatToCreate(CreateUserDTO $createUserDTO): array
    {
        return [
            UserDBConstants::NAME => $createUserDTO->getName(),
            UserDBConstants::EMAIL => $createUserDTO->getEmail(),
            UserDBConstants::ROLE => $createUserDTO->getRole(),
            UserDBConstants::TELEPHONE => $createUserDTO->getTelephone(),
            UserDBConstants::PASSWORD => $this->passwordHash($createUserDTO->getPassword())
        ];
    }

    /**
     * @param CreateUserDTO $createUserDTO
     * @return array
     * @throws ConflictException
     */
    public function create(CreateUserDTO $createUserDTO): array
    {
        $this->checkUserNotExistByEmail($createUserDTO->getEmail());
        return $this->repository->create($this->formatToCreate($createUserDTO));
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getBannedAtById(string $id): ?string
    {
        return $this->repository->getBannedAtById($id);
    }

    /**
     * @param string|null $bannedDateTime
     * @return null[]|string[]
     */
    private function formatBannedAt(?string $bannedDateTime): array
    {
        return [
            UserDBConstants::BANNED_AT => $bannedDateTime
        ];
    }

    /**
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function banned(string $id): array
    {
        $this->checkIsExist($id);
        $this->getBannedAtById($id) !== null
            ? $this->repository->updateBannedAt($id, $this->formatBannedAt(null))
            : $this->repository->updateBannedAt($id, $this->formatBannedAt(now()));
        return $this->show($id);
    }

    /**
     * @param UpdateUserDTO $updateUserDTO
     * @return array
     */
    private function formatToUpdate(UpdateUserDTO $updateUserDTO): array
    {
        return [
            UserDBConstants::NAME => $updateUserDTO->getName(),
            UserDBConstants::EMAIL => $updateUserDTO->getEmail(),
            UserDBConstants::ROLE => $updateUserDTO->getRole(),
            UserDBConstants::TELEPHONE => $updateUserDTO->getTelephone(),
        ];
    }

    /**
     * @param UpdateUserDTO $updateUserDTO
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(UpdateUserDTO $updateUserDTO): array
    {
        $this->checkIsExist($updateUserDTO->getUserId());
        $this->IsEmailDuplicated($updateUserDTO->getEmail(), $updateUserDTO->getUserId());
        $this->repository->update($this->formatToUpdate($updateUserDTO), $updateUserDTO->getUserId());
        return $this->repository->show($updateUserDTO->getUserId());
    }

    /**
     * @param string $email
     * @param string $userId
     * @return void
     * @throws ConflictException
     */
    private function IsEmailDuplicated(string $email, string $userId): void
    {
        $userByEmail = $this->repository->getUserByEmail($email);

        if ($userByEmail !== null && $userByEmail['id'] !== $userId) {
            throw new ConflictException("User is already exist");
        }
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function checkIsUserExistByUserId(string $userId): bool
    {
        return $this->repository->checkIsExist($userId);
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function checkIsUserDoesNotExistByUserId(string $userId): bool
    {
        return !$this->repository->checkIsExist($userId);
    }

    /**
     * @param string $id
     * @param CreatePhotoDTO $photo
     * @return array
     * @throws NotFoundException
     */
    public function uploadPhotos(string $id, CreatePhotoDTO $photo): array
    {
        $this->checkIsExist($id);

        $this->repository->update($this->formatForUploadAvatar($photo), $id);
        $this->photoService->storagePhoto($photo->getPathForDB(), $this->photoService->getPhotoContent($photo->getCurrentPath()));
        return $this->show($id);
    }

    /**
     * @param string $id
     * @return bool
     * @throws NotFoundException
     */
    public function deletePhoto(string $id): bool
    {
        $this->checkIsExist($id);
        $oldPath = $this->repository->getPhotoPathById($id);
        if ($oldPath == null) {
            return true;
        }
        $this->repository->update($this->formatForDeleteAvatar(), $id);
        return $this->photoService->deleteOldPhoto($oldPath);
    }

    /**
     * @param CreatePhotoDTO $photo
     * @return array
     */
    private function formatForUploadAvatar(CreatePhotoDTO $photo): array
    {
        return [
            UserDBConstants::AVATAR => $photo->getPathForDB()
        ];
    }

    /**
     * @return null[]
     */
    private function formatForDeleteAvatar(): array
    {
        return [
            UserDBConstants::AVATAR => null
        ];
    }

    /**
     * @param string $email
     * @return void
     * @throws NotFoundException
     */
    public function checkUserExistByEmail(string $email): void
    {
        if ($this->repository->checkUserExistByEmail($email) == false) {
            throw new NotFoundException("User is not found");
        }
    }

    /**
     * @param string $email
     * @return void
     * @throws ConflictException
     */
    public function checkUserNotExistByEmail(string $email): void
    {
        if ($this->repository->checkUserExistByEmail($email) == true) {
            throw new ConflictException("User is already exist");
        }
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if ($this->repository->checkIsExist($id) == false) {
            throw new NotFoundException("User is not found");
        }
    }

    /**
     * @param string $id
     * @return void
     * @throws ForbiddenException
     */
    public function checkIsUserBanned(string $id): void
    {
        if ($this->repository->getUserBannedStatus($id) != null) {
            throw new ForbiddenException("User is banned");
        }
    }
}
