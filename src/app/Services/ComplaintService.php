<?php

namespace App\Services;

use App\Constants\DB\ComplaintDBConstants;
use App\DTO\Complaint\AnswerComplaintDTO;
use App\DTO\Complaint\CreateComplaintDTO;
use App\DTO\Complaint\FilterComplaintDTO;
use App\Exceptions\NotFoundException;
use App\Repositories\ComplaintRepository;
use App\Repositories\Interfaces\ComplaintRepositoryInterface;
use App\Services\System\CRUDService;

class ComplaintService extends CrudService
{
    public function __construct(
        ComplaintRepositoryInterface $repository,
        private UserService          $userService,
        private EventService         $eventService,
    )
    {
        /** @var ComplaintRepository $repository */
        $this->repository = $repository;
        parent::__construct($repository);
    }
//
//    /**
//     * @return array
//     */
//    public function showTableWith(): array
//    {
//        return $this->repository->getComplaintsWith();
//    }

    /**
     * @return array
     */
    public function unsolved(): array
    {
        return $this->repository->unsolved();
    }

    /**
     * @param string $assigneeId
     * @return array
     * @throws NotFoundException
     */
    public function getAssigneeComplaints(string $assigneeId): array
    {
        $this->userService->checkIsExist($assigneeId);
        return $this->repository->getAssigneeComplaints($assigneeId);
    }

    /**
     * @param string $authorId
     * @return array
     * @throws NotFoundException
     */
    public function getAuthorComplaints(string $authorId): array
    {
        $this->userService->checkIsExist($authorId);
        return $this->repository->getAuthorComplaints($authorId);
    }

    /**
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function read(string $id): array
    {
        $this->checkIsExist($id);
        $this->repository->update([ComplaintDBConstants::READ_AT => now()], $id);
        return $this->repository->show($id);
    }

    /**
     * @param string $complaintId
     * @param string $assigneeId
     * @return array
     * @throws NotFoundException
     */
    public function toAssign(string $complaintId, string $assigneeId): array
    {
        $this->checkIsExist($complaintId);
        $this->userService->checkIsExist($assigneeId);
        $this->repository->update([ComplaintDBConstants::ASSIGNEE => $assigneeId], $complaintId);
        return $this->repository->show($complaintId);

    }

    /**
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function unassign(string $id): array
    {
        $this->checkIsExist($id);
        $this->repository->update([ComplaintDBConstants::ASSIGNEE => null], $id);
        return $this->repository->show($id);
    }

    /**
     * @param CreateComplaintDTO $createComplaintDTO
     * @return array
     */
    private function formatToCreate(CreateComplaintDTO $createComplaintDTO): array
    {
        return [
            ComplaintDBConstants::EVENT_ID => $createComplaintDTO->getEventId(),
            ComplaintDBConstants::AUTHOR_ID => $createComplaintDTO->getAuthorId(),
            ComplaintDBConstants::CAUSE_MESSAGE => $createComplaintDTO->getCauseMessage(),
            ComplaintDBConstants::CAUSE_DESCRIPTION => $createComplaintDTO->getCauseDescription(),
        ];
    }

    /**
     * @param CreateComplaintDTO $createComplaintDTO
     * @return array
     * @throws NotFoundException
     */
    public function create(CreateComplaintDTO $createComplaintDTO): array
    {
        $this->userService->checkIsExist($createComplaintDTO->getAuthorId());
        $this->eventService->checkIsExist($createComplaintDTO->getEventId());
        return $this->repository->create($this->formatToCreate($createComplaintDTO));
    }

    /**
     * @param AnswerComplaintDTO $answerComplaintDTO
     * @return array
     */
    private function formatAnswerToRecord(AnswerComplaintDTO $answerComplaintDTO): array
    {
        return [
//            ComplaintDBConstants::RESOLVER_ID => $answerComplaintDTO->getResolverId(),
            ComplaintDBConstants::RESOLVE_MESSAGE => $answerComplaintDTO->getResolveMessage(),
            ComplaintDBConstants::RESOLVE_DESCRIPTION => $answerComplaintDTO->getResolveDescription(),
            ComplaintDBConstants::RESOLVED_AT => now(),
        ];
    }

    /**
     * @param AnswerComplaintDTO $answerComplaintDTO
     * @return array
     * @throws NotFoundException
     */
    public function update(AnswerComplaintDTO $answerComplaintDTO): array
    {
        $this->checkIsExist($answerComplaintDTO->getComplaintId());
        $this->repository->update(
            $this->formatAnswerToRecord($answerComplaintDTO),
            $answerComplaintDTO->getComplaintId()
        );
        return $this->repository->show($answerComplaintDTO->getComplaintId());
    }

    /**
     * @param FilterComplaintDTO $filterComplaintDTO
     * @return array|null
     */
    public function filter(FilterComplaintDTO $filterComplaintDTO): ?array
    {
        return $this->repository->filter($filterComplaintDTO);
    }

    /**
     * @param array|null $searchBy
     * @return string|null
     */
    public function isSearchByCauseDescription(?array $searchBy): ?string
    {
        if (!empty ($searchBy)) {
            foreach ($searchBy as $elementOfSearchBy) {
                if ($elementOfSearchBy === ComplaintDBConstants::CAUSE_DESCRIPTION) {
                    return $elementOfSearchBy;
                }
            }
        }
        return null;
    }

    /**
     * @param array|null $searchBy
     * @return string|null
     */
    public function isSearchByResolveDescription(?array $searchBy): ?string
    {
        if (!empty ($searchBy)) {

            foreach ($searchBy as $elementOfSearchBy) {
                if ($elementOfSearchBy === ComplaintDBConstants::RESOLVE_DESCRIPTION) {
                    return $elementOfSearchBy;
                }
            }
        }
        return null;
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Complaint is not found");

        }
    }
}
