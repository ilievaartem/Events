<?php

namespace App\Repositories;

use App\Constants\DB\ComplaintDBConstants;
use App\DTO\Complaint\FilterComplaintDTO;
use App\Models\Complaint;
use App\Repositories\Interfaces\ComplaintRepositoryInterface;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{

    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array
    {
        return $this->model::query()->when($filterComplaintDTO->getPhrase() != null, function ($query) use ($filterComplaintDTO) {
            return $query->when(
                $filterComplaintDTO->getSearchByResolveDescription() != null,
                function ($query) use ($filterComplaintDTO) {
                    return $query->where(ComplaintDBConstants::RESOLVE_DESCRIPTION, 'like', '%' . $filterComplaintDTO->getPhrase() . '%');
                }
            )
                ->when(
                    ($filterComplaintDTO->getSearchByCauseDescription() != null),
                    function ($query) use ($filterComplaintDTO) {
                        return $query->where(ComplaintDBConstants::CAUSE_DESCRIPTION, 'like', '%' . $filterComplaintDTO->getPhrase() . '%');
                    }
                );
        })
            ->when($filterComplaintDTO->getAuthorId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::AUTHOR_ID, $filterComplaintDTO->getAuthorId());
            })
            ->when($filterComplaintDTO->getEventId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::EVENT_ID, $filterComplaintDTO->getEventId());
            })
            ->when($filterComplaintDTO->getAssigneeId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::ASSIGNEE, $filterComplaintDTO->getAssigneeId());
            })
            ->when($filterComplaintDTO->getCauseMessage() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::CAUSE_MESSAGE, $filterComplaintDTO->getCauseMessage());
            })
            ->when($filterComplaintDTO->getResolveMessage() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::RESOLVE_MESSAGE, $filterComplaintDTO->getResolveMessage());
            })
            ->when($filterComplaintDTO->getResolverId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::RESOLVER_ID, $filterComplaintDTO->getResolverId());
            })
            ->when(
                $filterComplaintDTO->getResolvedFrom() != null && $filterComplaintDTO->getResolvedTo() != null,
                function ($query) use ($filterComplaintDTO) {
                    return $query->whereBetween(ComplaintDBConstants::RESOLVED_AT, [
                        $filterComplaintDTO->getResolvedFrom(),
                        $filterComplaintDTO->getResolvedTo()
                    ]);
                }
            )
            ->when(
                $filterComplaintDTO->getReadFrom() != null && $filterComplaintDTO->getReadTo() != null,
                function ($query) use ($filterComplaintDTO) {
                    return $query->whereBetween(ComplaintDBConstants::READ_AT, [
                        $filterComplaintDTO->getReadFrom(),
                        $filterComplaintDTO->getReadTo()
                    ]);
                }
            )
            ->when(
                $filterComplaintDTO->getCreatedFrom() != null && $filterComplaintDTO->getCreatedTo() != null,
                function ($query) use ($filterComplaintDTO) {
                    return $query->whereBetween(ComplaintDBConstants::CREATED_AT, [
                        $filterComplaintDTO->getCreatedFrom(),
                        $filterComplaintDTO->getCreatedTo()
                    ]);
                }
            )
            ->paginate(self::PER_PAGE)->toArray();

    }
}
