<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Constants\DB\UserDBConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PhotoService $photoService,
        private EventService $eventService,
        private CommentService $commentService,
        private QuestionService $questionService
    ) {
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
        $this->checkIsExist($id);
        return $this->userRepository->show($id);
    }

    public function userEvents(string $id): array
    {
        $this->checkIsExist($id);
        return $this->eventService->getEventsByAuthorId($id);
    }
    public function userComments(string $id): array
    {
        $this->checkIsExist($id);
        return $this->commentService->getCommentsByAuthorId($id);
    }
    public function userQuestions(string $id): array
    {
        $this->checkIsExist($id);
        return $this->questionService->getQuestionsByAuthorId($id);
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
    public function update(?string $name, ?string $email, ?string $password, string $id): array
    {
        $this->checkIsExist($id);
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
        $this->photoService->storagePhoto($photo->getPathForDB(), $this->photoService->getPhotoContentForEvent($photo));
        return $this->show($id);
    }
    public function deletePhoto(string $id): bool
    {
        $this->checkIsExist($id);
        $oldPath = $this->userRepository->getPhotoPathById($id);
        if ($oldPath != null) {
            $this->userRepository->update($this->formatForDeleteAvatar(), $id);
            return $this->photoService->deleteOldPhoto($oldPath);
        }
        return true;
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
    public function checkIsExist(string $id): void
    {
        if ($this->userRepository->checkIsExist($id) == false) {
            throw new NotFoundException("User is not found");
        }
    }
}
