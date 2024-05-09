<?php

namespace App\Repositories\Interfaces;

interface EventArchiveRepositoryInterface extends BaseRepositoryInterface
{
    public function showUserEventArchives($userId): array;
}
