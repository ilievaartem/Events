<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIsExistByName(string $name): bool;

}
