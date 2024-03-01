<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Constants\DB\UserDBConstants;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository, private PhotoService $photoService)
    {
        $this->userRepository = $userRepository;
    }
    public function create(string $name, string $email, string $role, string $telephone, string $password): array
    {
        $password = Hash::make($password);
        $user = [
            UserDBConstants::NAME => $name,
            UserDBConstants::EMAIL => $email,
            UserDBConstants::ROLE => $role,
            UserDBConstants::TELEPHONE => $telephone,
            UserDBConstants::PASSWORD => $password
        ];
        return $this->userRepository->create($user);
    }
    public function index(): array
    {
        $index = $this->userRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Users are not found");
    }
    public function show(string $id): ?array
    {
        $show = $this->userRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("User is not found");

    }

    public function userEvents(string $id): array
    {
        $getById = $this->userRepository->show($id);
        if ($getById != null) {
            return $this->userRepository->userEvents($id);
        }
        throw new NotFoundException("User is not found");
    }
    public function delete(string $id): bool
    {
        return $this->userRepository->delete($id);
    }
    public function update(?string $name, ?string $email, ?string $password, string $id): array
    {
        $password = Hash::make($password);
        $user = [
            UserDBConstants::NAME => $name,
            UserDBConstants::EMAIL => $email,
            UserDBConstants::PASSWORD => $password
        ];
        $this->userRepository->update($user, $id);
        return $this->userRepository->show($id);
    }
    public function checkIsUserExistByUserId(string $userId): bool
    {
        return $this->userRepository->checkIsUserExistByUserId($userId);
    }
    public function checkIsUserDoesNotExistByUserId(string $userId): bool
    {
        return !$this->userRepository->checkIsUserExistByUserId($userId);
    }
    public function updatePhotos(string $id, ?string $photo, string $photoExtension): array
    {
        $alreadyExistedPhotosPaths = $this->userRepository->getPhotoPathById($id);
        $photoPath = $this->photoService->makeMainPhotoDirectoryNameForUser($id, $photoExtension);
        $this->userRepository->updatePhoto($id, $photoPath);
        $this->photoService->loadPhoto($photo, $photoPath);
        $this->photoService->deleteOldPhoto($alreadyExistedPhotosPaths);
        return $this->userRepository->show($id);
    }
}
