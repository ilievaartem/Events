<?php

namespace App\Services;

use App\Constants\DB\ComplaintDBConstants;
use App\DTO\Complaint\FilterComplaintDTO;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\ComplaintRepositoryInterface;

class ComplaintService
{
    public function __construct(private ComplaintRepositoryInterface $complaintRepository)
    {

    }
    public function index(): array
    {
        $index = $this->complaintRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Complaints are not found");
    }
    public function show(string $id): ?array
    {
        $show = $this->complaintRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Complaint is not found");
    }
    public function create(string $eventId, string $authorId, string $causeMessage, string $causeDescription): ?array
    {

        $complaint = [
            ComplaintDBConstants::EVENT_ID => $eventId,
            ComplaintDBConstants::AUTHOR_ID => $authorId,
            ComplaintDBConstants::CAUSE_MESSAGE => $causeMessage,
            ComplaintDBConstants::CAUSE_DESCRIPTION => $causeDescription,
        ];
        return $this->complaintRepository->create($complaint);
    }
    public function delete(string $id): bool
    {
        return $this->complaintRepository->delete($id);
    }
    public function update(string $complaintId, string $resolverId, string $resolveMessage, string $resolveDescription): array
    {
        $complaint = [
            ComplaintDBConstants::RESOLVER_ID => $resolverId,
            ComplaintDBConstants::RESOLVE_MESSAGE => $resolveMessage,
            ComplaintDBConstants::RESOLVE_DESCRIPTION => $resolveDescription,
            ComplaintDBConstants::RESOLVED_AT => now(),
        ];
        $this->complaintRepository->update($complaint, $complaintId);
        return $this->complaintRepository->show($complaintId);
    }
    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array
    {
        return $this->complaintRepository->filter($filterComplaintDTO);

    }
}
