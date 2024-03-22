<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public const PER_PAGE = 10;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function create(array $data): array
    {
        return $this->model->create($data)->toArray();
    }
    public function insert(array $data): bool
    {
        return $this->model->insert($data);
    }
    public function update(array $data, int|string $id): bool
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function delete(int|string $id): bool
    {
        $delete = $this->model->where('id', $id)->delete();
        return true;
    }
    public function show(int|string $id): array
    {
        return $this->model->find($id)->toArray();
    }
    public function index(): array
    {
        return $this->model->paginate(self::PER_PAGE)->toArray();
    }
    public function checkIsExist(int|string $id): bool
    {
        return $this->model->query()->find($id)->exists();
    }

}
