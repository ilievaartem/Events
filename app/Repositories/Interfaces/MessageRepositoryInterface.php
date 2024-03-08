<?php

namespace App\Repositories\Interfaces;

interface MessageRepositoryInterface extends BaseRepositoryInterface
{
    public function getMessageCreatedAt(string $id): string;

}
