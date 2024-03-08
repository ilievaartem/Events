<?php

namespace App\Services;

use App\Constants\DB\InteresterDBConstants;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\InteresterRepositoryInterface;

class InteresterService
{
    public function __construct(
        private InteresterRepositoryInterface $interesterRepository,
        private EventService $eventService,
        private UserService $userService
    ) {

    }
    public function index(): array
    {
        $index = $this->interesterRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Interesters are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->interesterRepository->show($id);
    }
    public function formatForCreate(string $eventId, string $authorId): array
    {
        return [
            InteresterDBConstants::EVENT_ID => $eventId,
            InteresterDBConstants::AUTHOR_ID => $authorId
        ];
    }
    public function checkIsInteresterExist(string $eventId, string $userId): bool
    {
        return $this->interesterRepository->checkIsInteresterExist($eventId, $userId);
    }
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string
    {
        return $this->interesterRepository->getIdByEventIdAndUserId($eventId, $userId);
    }
    private function checkIsInteresterEventAuthor(string $eventId, string $applierId): void
    {
        if ($this->eventService->getAuthorIdByEventId($eventId) == $applierId) {
            throw new BadRequestException("Interester is event author");
        }
    }
    public function update(string $eventId, string $userId): bool|array
    {
        $this->userService->checkIsExist($userId);
        $this->eventService->checkIsExist($eventId);
        $this->checkIsInteresterEventAuthor($eventId, $userId);
        return $this->checkIsInteresterExist($eventId, $userId) === false
            ? $this->interesterRepository->create($this->formatForCreate($eventId, $userId))
            : $this->interesterRepository->delete($this->interesterRepository->getIdByEventIdAndUserId($eventId, $userId));
    }
    public function checkIsExist(string $id): void
    {
        if ($this->interesterRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Interester is not found");
        }
    }
}
