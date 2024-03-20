<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Constants\DB\UserDBConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
use App\Jobs\LoadUserAvatarJob;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PhotoService $photoService,
    ) {
    }

    private function passwordHash(string $password): string
    {
        return Hash::make($password);
    }
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
    public function create(CreateUserDTO $createUserDTO): array
    {
        $this->checkUserNotExistByEmail($createUserDTO->getEmail());
        return $this->userRepository->create($this->formatToCreate($createUserDTO));
    }
    public function index(): array
    {
        $index = $this->userRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Users are not found");
    }
    public function show(string $id): array
    {
        $this->checkIsExist($id);
        return $this->userRepository->show($id);
    }

    public function getBannedAtById(string $id): ?string
    {
        return $this->userRepository->getBannedAtById($id);
    }
    public function delete(string $id): bool
    {
        return $this->userRepository->delete($id);
    }
    private function formatBannedAt(?string $bannedDateTime): array
    {
        return [
            UserDBConstants::BANNED_AT => $bannedDateTime
        ];
    }
    public function banned(string $id): array
    {
        $this->checkIsExist($id);
        $this->getBannedAtById($id) !== null
            ? $this->userRepository->updateBannedAt($id, $this->formatBannedAt(null))
            : $this->userRepository->updateBannedAt($id, $this->formatBannedAt(now()));
        return $this->show($id);
    }
    private function formatToUpdate(UpdateUserDTO $updateUserDTO): array
    {
        return [
            UserDBConstants::NAME => $updateUserDTO->getName(),
            UserDBConstants::EMAIL => $updateUserDTO->getEmail(),
            UserDBConstants::PASSWORD => $this->passwordHash($updateUserDTO->getPassword())
        ];
    }
    public function update(UpdateUserDTO $updateUserDTO): array
    {
        $this->checkIsExist($updateUserDTO->getUserId());
        $this->checkUserNotExistByEmail($updateUserDTO->getEmail());
        $this->userRepository->update($this->formatToUpdate($updateUserDTO), $updateUserDTO->getUserId());
        return $this->userRepository->show($updateUserDTO->getUserId());
    }
    public function checkIsUserExistByUserId(string $userId): bool
    {
        return $this->userRepository->checkIsExist($userId);
    }
    public function checkIsUserDoesNotExistByUserId(string $userId): bool
    {
        return !$this->userRepository->checkIsExist($userId);
    }
    public function uploadPhotos(string $id, CreatePhotoDTO $photo): array
    {
        $this->checkIsExist($id);

        $this->userRepository->update($this->formatForUploadAvatar($photo), $id);
        $this->photoService->storagePhoto($photo->getPathForDB(), $this->photoService->getPhotoContent($photo->getCurrentPath()));
        return $this->show($id);
    }

    public function deletePhoto(string $id): bool
    {
        $this->checkIsExist($id);
        $oldPath = $this->userRepository->getPhotoPathById($id);
        if ($oldPath == null) {
            return true;
        }
        $this->userRepository->update($this->formatForDeleteAvatar(), $id);
        return $this->photoService->deleteOldPhoto($oldPath);
    }
    private function formatForUploadAvatar(CreatePhotoDTO $photo): array
    {
        return [
            UserDBConstants::AVATAR => $photo->getPathForDB()
        ];
    }
    private function formatForDeleteAvatar(): array
    {
        return [
            UserDBConstants::AVATAR => null
        ];
    }
    public function checkUserExistByEmail(string $email): void
    {
        if ($this->userRepository->checkUserExistByEmail($email) == false) {
            throw new NotFoundException("User is not found");
        }
    }
    public function checkUserNotExistByEmail(string $email): void
    {
        if ($this->userRepository->checkUserExistByEmail($email) == true) {
            throw new ConflictException("User is already exist");
        }
    }
    public function checkIsExist(string $id): void
    {
        if ($this->userRepository->checkIsExist($id) == false) {
            throw new NotFoundException("User is not found");
        }
    }
    public function checkIsUserBanned(string $id): void
    {
        dd($this->userRepository->getUserBannedStatus($id));
        if ($this->userRepository->getUserBannedStatus($id) != null) {
            throw new ForbiddenException("User is banned");
        }
    }
}
