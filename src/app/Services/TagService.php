<?php

namespace App\Services;

use App\Constants\DB\TagDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagService
{
    public function __construct(private TagRepositoryInterface $tagRepository)
    {
    }
    public function create(string $name): array
    {
        return $this->tagRepository->checkIsExistByName($name)
            ? throw new ConflictException("Tag already exist")
            : $this->tagRepository->create($this->formatNameForRecord($name));
    }
    private function formatNameForRecord(string $name): array
    {
        return [
            TagDBConstants::NAME => $name
        ];
    }
    public function delete(int $id): bool
    {
        return $this->tagRepository->delete($id);
    }
    public function update(string $name, int $id): array
    {
        $this->checkIsExist($id);
        $this->tagRepository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->tagRepository->update($this->formatNameForRecord($name), $id);
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
        $this->checkIsExist($id);
        return $this->tagRepository->show($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->tagRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Tag is not found");
        }
    }

}
