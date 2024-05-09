<?php

namespace App\DTO\Complaint;

use App\DTO\Contracts\DTOContract;

class AnswerComplaintDTO implements DTOContract
{
    public function __construct(
        private readonly string $complaintId,
        private readonly string $resolverId,
        private readonly string $resolveMessage,
        private readonly string $resolveDescription,
    ) {
    }
    public function getComplaintId(): string
    {
        return $this->complaintId;
    }
    public function getResolverId(): string
    {
        return $this->resolverId;
    }
    public function getResolveMessage(): string
    {
        return $this->resolveMessage;
    }
    public function getResolveDescription(): string
    {
        return $this->resolveDescription;
    }
}
