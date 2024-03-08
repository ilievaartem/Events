<?php

namespace App\Repositories\Interfaces;

use App\DTO\Complaint\FilterComplaintDTO;

interface ComplaintRepositoryInterface extends BaseRepositoryInterface
{
    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array;
}
