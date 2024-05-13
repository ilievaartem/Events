<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public const PER_PAGE = 10;
    private const DEFAULT_ORDER_DIRECTION = 'asc';
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
    public function index(?array $filter): array
    {
        return $this->model->paginate(self::PER_PAGE)->toArray();
    }
    public function getAll(?string $orderFieldName, ?string $directionName = self::DEFAULT_ORDER_DIRECTION): array
    {
        $model = $this->model->query();
        //TODO create field order validation exist
        if (!empty($orderFieldName)) {
            $model->orderBy($orderFieldName, $directionName);
        }
        return $model->get()->toArray();

    }
    public function checkIsExist(int|string $id): bool
    {
        $entity = $this->model->query()->find($id);
        return !empty($entity);
    }

}
