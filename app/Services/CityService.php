<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityService
{
    public function __construct(private CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    public function index(): array
    {
        $index = $this->cityRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Cities are not found");
    }
    public function show(int $id): ?array
    {
        $show = $this->cityRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("City is not found");
    }
    public function create(array $data): array
    {
        return $this->cityRepository->create($data);
    }
    public function delete(int $id): bool
    {
        return $this->cityRepository->delete($id);
    }
    public function update(array $data, int $id): array
    {
        $this->cityRepository->update($data, $id);
        return $this->cityRepository->show($id);
    }
}
