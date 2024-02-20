<?php

namespace App\Services;

use App\Constants\DB\ApplierDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\ApplierRepositoryInterface;

class ApplierService
{
    public function __construct(private ApplierRepositoryInterface $applierRepository)
    {

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
        $show = $this->applierRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Applier is not found");
    }
    public function create(string $eventId, string $authorId): array
    {
        $applier = [
            ApplierDBConstants::EVENT_ID => $eventId,
            ApplierDBConstants::AUTHOR_ID => $authorId
        ];
        return $this->applierRepository->create($applier);
    }
    public function delete(string $id): bool
    {
        return $this->applierRepository->delete($id);
    }
    public function update(array $data, string $id): array
    {
        $this->applierRepository->update($data, $id);
        return $this->applierRepository->show($id);
    }
}
