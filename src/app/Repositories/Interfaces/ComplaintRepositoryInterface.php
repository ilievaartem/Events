<?php

namespace App\Repositories\Interfaces;

use App\DTO\Complaint\FilterComplaintDTO;

interface ComplaintRepositoryInterface extends BaseRepositoryInterface
{
    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array;
    public function unsolved(): array;
    public function getAssigneeComplaints(string $assigneeId): array;
    public function getAuthorComplaints(string $authorId): array;
    public function getComplaintsWith(): array;

}
