<?php

namespace App\Services;

use App\DTO\Event\CreateEventDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventArchiveRepositoryInterface;

class EventArchiveService
{
    public function __construct(
        private EventArchiveRepositoryInterface $eventArchiveRepository,
        private EventService $eventService,
        private UserService $userService,
    ) {
    }


    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->eventArchiveRepository->show($id);
    }
    public function showUserEventArchives($userId): array
    {
        $this->userService->checkIsExist($userId);
        return $this->eventArchiveRepository->showUserEventArchives($userId);
    }
    public function archive(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        $this->checkIsNotExist($eventId);
        $this->eventArchiveRepository->create($this->eventService->show($eventId));
        $this->eventService->delete($eventId);
        return $this->show($eventId);
    }
    public function unarchive(string $id): array
    {
        $this->checkIsExist($id);
        $event = $this->show($id);
        $this->delete($id);
        return $event;
    }
    public function delete(string $id): bool
    {
        return $this->eventArchiveRepository->delete($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->eventArchiveRepository->checkIsExist($id) == false) {
            throw new NotFoundException("EventArchive is not found");
        }
    }
    public function checkIsNotExist(string $id): void
    {
        if ($this->eventArchiveRepository->checkIsExist($id) == true) {
            throw new ConflictException("EventArchive is already exist");
        }
    }

}
