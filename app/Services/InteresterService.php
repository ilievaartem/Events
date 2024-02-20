<?php

namespace App\Services;

use App\Constants\DB\InteresterDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\InteresterRepositoryInterface;

class InteresterService
{
    public function __construct(private InteresterRepositoryInterface $interesterRepository)
    {

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
        $show = $this->interesterRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Interester is not found");
    }
    public function create(string $eventId, string $authorId): array
    {
        $interester = [
            InteresterDBConstants::EVENT_ID => $eventId,
            InteresterDBConstants::AUTHOR_ID => $authorId
        ];
        return $this->interesterRepository->create($interester);
    }
    public function delete(string $id): bool
    {
        return $this->interesterRepository->delete($id);
    }
    public function update(array $data, string $id): array
    {
        $this->interesterRepository->update($data, $id);
        return $this->interesterRepository->show($id);
    }
}
