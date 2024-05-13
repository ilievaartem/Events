<?php


namespace App\Http\Controllers\Api;

use App\Constants\Request\ComplaintRequestConstants;

use App\DTO\Complaint\FilterComplaintDTO;
use App\Factory\Complaint\AnswerComplaintDTOFactory;
use App\Factory\Complaint\CreateComplaintDTOFactory;
use App\Factory\Complaint\FilterComplaintDTOFactory;
use App\Http\Requests\Complaints\ComplaintAssignRequest;
use App\Http\Requests\Complaints\ComplaintFilterRequest;
use App\Services\AuthWrapperService;
use App\Services\ComplaintService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function __construct(
        private ComplaintService $complaintService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function unsolved(): JsonResponse
    {
        return response()->json($this->complaintService->unsolved());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->complaintService->show($id));
    }
    public function getReceiverComplaints(string $assigneeId): JsonResponse
    {
        return response()->json($this->complaintService->getAssigneeComplaints($assigneeId));
    }
    public function getAuthorComplaints(string $authorId): JsonResponse
    {
        return response()->json($this->complaintService->getAuthorComplaints($authorId));
    }
    public function read(string $id): JsonResponse
    {
        return response()->json($this->complaintService->read($id));
    }
    public function toAssign(ComplaintAssignRequest $request, string $complaintId): JsonResponse
    {
        return response()->json(
            $this->complaintService->toAssign(
                $complaintId,
                $request->input(ComplaintRequestConstants::ASSIGNEE)
            )
        );
    }
    public function unassign(string $id): JsonResponse
    {
        return response()->json($this->complaintService->unassign($id));
    }
    public function filter(ComplaintFilterRequest $request, FilterComplaintDTOFactory $filterComplaintDTOFactory): JsonResponse
    {
        return response()->json($this->complaintService->filter($filterComplaintDTOFactory->make($request)));
    }
    public function create(Request $request, string $eventId, CreateComplaintDTOFactory $createComplaintDTOFactory): JsonResponse
    {
        return response()->json($this->complaintService->create($createComplaintDTOFactory->make($request, $eventId)));
    }
    public function answer(Request $request, string $complaintId, AnswerComplaintDTOFactory $answerComplaintDTOFactory): JsonResponse
    {
        return response()->json($this->complaintService->update($answerComplaintDTOFactory->make($request, $complaintId)));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->complaintService->delete($id)]);
    }
}
