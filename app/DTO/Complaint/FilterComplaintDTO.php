<?php

namespace App\DTO\Complaint;

use App\DTO\Contracts\DTOContract;

class FilterComplaintDTO implements DTOContract
{
    public function __construct(
        private readonly ?string $phrase,
        private readonly ?string $authorId,
        private readonly ?string $eventId,
        private readonly ?string $assignee,
        private readonly ?string $causeMessage,
        private readonly ?string $searchByCauseDescription,
        private readonly ?string $resolveMessage,
        private readonly ?string $searchByResolveDescription,
        private readonly ?string $resolverId,
        private readonly ?string $resolvedFrom,
        private readonly ?string $resolvedTo,
        private readonly ?string $readFrom,
        private readonly ?string $readTo,
        private readonly ?string $createdFrom,
        private readonly ?string $createdTo,

    ) {
    }
    public function getPhrase(): ?string
    {
        return $this->phrase;
    }
    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }
    public function getEventId(): ?string
    {
        return $this->eventId;
    }
    public function getAssigneeId(): ?string
    {
        return $this->assignee;
    }
    public function getCauseMessage(): ?string
    {
        return $this->causeMessage;
    }
    public function getSearchByCauseDescription(): ?string
    {
        return $this->searchByCauseDescription;
    }
    public function getResolveMessage(): ?string
    {
        return $this->resolveMessage;
    }
    public function getSearchByResolveDescription(): ?string
    {
        return $this->searchByResolveDescription;
    }
    public function getResolverId(): ?string
    {
        return $this->resolverId;
    }
    public function getResolvedFrom(): ?string
    {
        return $this->resolvedFrom;
    }
    public function getResolvedTo(): ?string
    {
        return $this->resolvedTo;
    }
    public function getReadFrom(): ?string
    {
        return $this->readFrom;
    }
    public function getReadTo(): ?string
    {
        return $this->readTo;
    }
    public function getCreatedFrom(): ?string
    {
        return $this->createdFrom;
    }
    public function getCreatedTo(): ?string
    {
        return $this->createdTo;
    }
}
