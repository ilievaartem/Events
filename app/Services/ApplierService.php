<?php

namespace App\Services;

use App\Constants\DB\ApplierDBConstants;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\ApplierRepositoryInterface;

class ApplierService
{
    public function __construct(
        private ApplierRepositoryInterface $applierRepository,
        private EventService $eventService,
        private UserService $userService
    ) {
    }
    public function index(): array
    {
        $index = $this->applierRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Appliers are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->applierRepository->show($id);
    }
    public function formatForCreate(string $eventId, string $authorId): array
    {
        return [
            ApplierDBConstants::EVENT_ID => $eventId,
            ApplierDBConstants::AUTHOR_ID => $authorId
        ];
    }
    public function checkIsApplierExist(string $eventId, string $userId): bool
    {
        return $this->applierRepository->checkIsApplierExist($eventId, $userId);
    }
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string
    {
        return $this->applierRepository->getIdByEventIdAndUserId($eventId, $userId);
    }
    private function checkIsApplierEventAuthor(string $eventId, string $applierId): void
    {
        if ($this->eventService->getAuthorIdByEventId($eventId) == $applierId) {
            throw new BadRequestException("Applier is event author");
        }
    }
    public function update(string $eventId, string $userId): bool
    {
        $this->userService->checkIsExist($userId);
        $this->eventService->checkIsExist($eventId);
        $this->checkIsApplierEventAuthor($eventId, $userId);
        $this->checkIsApplierExist($eventId, $userId) === false
            ? $this->applierRepository->create($this->formatForCreate($eventId, $userId))
            : $this->applierRepository->delete($this->applierRepository->getIdByEventIdAndUserId($eventId, $userId));
        return true;
    }
    public function checkIsExist(string $id): void
    {
        if ($this->applierRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Applier is not found");
        }
    }
}
