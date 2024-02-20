<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryService
{
    public function __construct(private CountryRepositoryInterface $countyRepository)
    {
        $this->countyRepository = $countyRepository;
    }
    public function index(): array
    {
        $index = $this->countyRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Countries are not found");
    }
    public function show(int $id): ?array
    {
        $show = $this->countyRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Country is not found");
    }
    public function create(array $data): array
    {
        return $this->countyRepository->create($data);
    }
    public function delete(int $id): bool
    {
        return $this->countyRepository->delete($id);
    }
    public function update(array $data, int $id): array
    {
        $this->countyRepository->update($data, $id);
        return $this->countyRepository->show($id);
    }

}
