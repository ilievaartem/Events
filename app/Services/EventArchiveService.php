<?php

namespace App\Services;

use App\DTO\Event\CreateEventDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\EventArchiveRepositoryInterface;

class EventArchiveService
{
    public function __construct(
        private EventArchiveRepositoryInterface $eventArchiveRepositoryInterface,
        private EventService $eventService,
    ) {
    }

    public function index(): array
    {
        $index = $this->eventArchiveRepositoryInterface->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("EventArchives are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->eventArchiveRepositoryInterface->show($id);
    }
    public function archive(string $eventId): array
    {
        $this->checkIsNotExist($eventId);
        $this->eventArchiveRepositoryInterface->create($this->eventService->show($eventId));
        $this->eventService->delete($eventId);
        return $this->show($eventId);
    }
    public function unarchive(string $id, CreateEventDTO $createEventDTO): array
    {
        $this->checkIsExist($id);
        $this->delete($id);
        return $this->eventService->create($createEventDTO);
    }
    public function delete(string $id): bool
    {
        return $this->eventArchiveRepositoryInterface->delete($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->eventArchiveRepositoryInterface->checkIsExist($id) == false) {
            throw new NotFoundException("EventArchive is not found");
        }
    }
    public function checkIsNotExist(string $id): void
    {
        if ($this->eventArchiveRepositoryInterface->checkIsExist($id) == true) {
            throw new AlreadyExistException("EventArchive is already exist");
        }
    }

}
