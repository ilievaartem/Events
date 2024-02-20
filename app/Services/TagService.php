<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagService
{
    public function __construct(private TagRepositoryInterface $tagRepository)
    {
    }
    public function create(array $data): array
    {
        return $this->tagRepository->create($data);
    }
    public function delete(int $id): bool
    {
        return $this->tagRepository->delete($id);
    }
    public function update(array $data, int $id): array
    {
        $this->tagRepository->update($data, $id);
        return $this->tagRepository->show($id);
    }
    public function index(): array
    {
        $index = $this->tagRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Tags is not found");
    }
    public function show(int $id): ?array
    {
        $show = $this->tagRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Tag is not found");
    }

}
