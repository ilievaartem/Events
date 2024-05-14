<?php

namespace App\Repositories;

use App\Constants\DB\ComplaintDBConstants;
use App\DTO\Complaint\FilterComplaintDTO;
use App\Models\Complaint;
use App\Repositories\Interfaces\ComplaintRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{
    public function unsolved(): array
    {
        return $this->model->query()->when(ComplaintDBConstants::RESOLVED_AT != null)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function getAssigneeComplaints(string $assigneeId): array
    {
        return $this->model->query()->where(ComplaintDBConstants::ASSIGNEE, $assigneeId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function getAuthorComplaints(string $authorId): array
    {
        return $this->model->query()->where(ComplaintDBConstants::AUTHOR_ID, $authorId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array
    {
        return $this->model::query()
            ->when($filterComplaintDTO->getPhrase() != null && $filterComplaintDTO->getSearchBy() == null, function (Builder $query) use ($filterComplaintDTO) {
                return $query->where(function (Builder $query) use ($filterComplaintDTO) {
                    $query
                        ->where(ComplaintDBConstants::RESOLVE_MESSAGE, 'like', '%' . $filterComplaintDTO->getPhrase() . '%')
                        ->orWhere(ComplaintDBConstants::CAUSE_MESSAGE, 'like', '%' . $filterComplaintDTO->getPhrase() . '%');
                });
            })
            ->when(
                $filterComplaintDTO->getPhrase() != null && $filterComplaintDTO->getSearchBy() != null,
                function (Builder $query) use ($filterComplaintDTO) {
                    return $query->where(function (Builder $query) use ($filterComplaintDTO) {
                        $query
                            ->when(
                                array_key_exists(ComplaintDBConstants::RESOLVE_MESSAGE, $filterComplaintDTO->getSearchBy()),
                                function (Builder $query) use ($filterComplaintDTO) {
                                    $query->where(ComplaintDBConstants::RESOLVE_MESSAGE, 'like', '%' . $filterComplaintDTO->getPhrase() . '%');
                                }
                            )
                            ->when(
                                array_key_exists(ComplaintDBConstants::CAUSE_MESSAGE, $filterComplaintDTO->getSearchBy()),
                                function (Builder $query) use ($filterComplaintDTO) {
                                    $query->orWhere(ComplaintDBConstants::CAUSE_MESSAGE, 'like', '%' . $filterComplaintDTO->getPhrase() . '%');
                                }
                            );
                    });
                }
            )
            ->when($filterComplaintDTO->getAuthorId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::AUTHOR_ID, $filterComplaintDTO->getAuthorId());
            })
            ->when($filterComplaintDTO->getEventId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::EVENT_ID, $filterComplaintDTO->getEventId());
            })
            ->when($filterComplaintDTO->getAssigneeId() != null, function ($query) use ($filterComplaintDTO) {
                return $query->where(ComplaintDBConstants::ASSIGNEE, $filterComplaintDTO->getAssigneeId());
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
            ->when(!empty($filterComplaintDTO->getSearch()), function ($query) use ($filterComplaintDTO) {
                return $query->where(function (Builder $query) use ($filterComplaintDTO) {
                    $query->where(ComplaintDBConstants::CAUSE_MESSAGE, 'like', '%' . $filterComplaintDTO->getSearch() . '%')
                        ->orWhere(ComplaintDBConstants::CAUSE_DESCRIPTION, 'like', '%' . $filterComplaintDTO->getSearch() . '%');
                });
            })
            ->when(!empty($filterComplaintDTO->getField()) && !empty($filterComplaintDTO->getDirection()), function (Builder $query) use ($filterComplaintDTO) {
                return $query->orderBy($filterComplaintDTO->getField(), $filterComplaintDTO->getDirection());
            })
            ->when((!empty($filterComplaintDTO->getResolvedAt()) && ($filterComplaintDTO->getResolvedAt() == 'resolved')), function ($query) use ($filterComplaintDTO) {
                return $query->whereNotNull('resolved_at');
            })
            ->when((!empty($filterComplaintDTO->getResolvedAt()) && ($filterComplaintDTO->getResolvedAt() == 'not_resolved')), function ($query) use ($filterComplaintDTO) {
                return $query->whereNull('resolved_at');
            })
            ->with('author', 'event')->paginate(self::PER_PAGE)->toArray();

    }
}
