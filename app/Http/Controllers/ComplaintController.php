<?php


namespace App\Http\Controllers;

use App\Constants\Request\ComplaintRequestConstants;

use App\DTO\Complaint\FilterComplaintDTO;
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
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->complaintService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->complaintService->show($id));
    }
    public function getReceiverComplaints(string $receiverId): JsonResponse
    {
        return response()->json($this->complaintService->getReceiverComplaints($receiverId));
    }
    public function getAuthorComplaints(string $authorId): JsonResponse
    {
        return response()->json($this->complaintService->getAuthorComplaints($authorId));
    }
    public function read(string $id): JsonResponse
    {
        return response()->json($this->complaintService->read($id));
    }
    public function toAssign(Request $request, string $complaintId): JsonResponse
    {
        return response()->json($this->complaintService->toAssign($complaintId, $request->input(ComplaintRequestConstants::ASSIGNEE)));
    }
    public function unassign(string $id): JsonResponse
    {
        return response()->json($this->complaintService->unassign($id));
    }
    public function filter(ComplaintFilterRequest $request): JsonResponse
    {

        $filterComplaintDTO = new FilterComplaintDTO(

            phrase: $request->input(ComplaintRequestConstants::PHRASE),
            authorId: $request->input(ComplaintRequestConstants::AUTHOR_ID),
            eventId: $request->input(ComplaintRequestConstants::EVENT_ID),
            assignee: $request->input(ComplaintRequestConstants::ASSIGNEE),
            causeMessage: $request->input(ComplaintRequestConstants::CAUSE_MESSAGE),
            searchByCauseDescription: $this->complaintService->isSearchByCauseDescription(
                $request->input(ComplaintRequestConstants::SEARCH_BY)
            ),
            resolveMessage: $request->input(ComplaintRequestConstants::RESOLVE_MESSAGE),
            searchByResolveDescription: $this->complaintService->isSearchByResolveDescription(
                $request->input(ComplaintRequestConstants::SEARCH_BY)
            ),
            resolverId: $request->input(ComplaintRequestConstants::RESOLVER_ID),
            resolvedFrom: $request->input(ComplaintRequestConstants::RESOLVED_FROM),
            resolvedTo: $request->input(ComplaintRequestConstants::RESOLVED_TO),
            readFrom: $request->input(ComplaintRequestConstants::READ_FROM),
            readTo: $request->input(ComplaintRequestConstants::READ_TO),
            createdFrom: $request->input(ComplaintRequestConstants::CREATED_FROM),
            createdTo: $request->input(ComplaintRequestConstants::CREATED_TO),
        );
        return response()->json($this->complaintService->filter($filterComplaintDTO));
    }
    public function create(Request $request, string $eventId): JsonResponse
    {
        $authorId = $this->authWrapperService->getAuthIdentifier();
        $causeMessage = $request->input(ComplaintRequestConstants::CAUSE_MESSAGE);
        $causeDescription = $request->input(ComplaintRequestConstants::CAUSE_DESCRIPTION);
        return response()->json($this->complaintService->create($eventId, $authorId, $causeMessage, $causeDescription));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $authorId = $this->authWrapperService->getAuthIdentifier();
        $resolveMessage = $request->input(ComplaintRequestConstants::RESOLVE_MESSAGE);
        $resolveDescription = $request->input(ComplaintRequestConstants::RESOLVE_DESCRIPTION);
        return response()->json($this->complaintService->update($id, $authorId, $resolveMessage, $resolveDescription));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->complaintService->delete($id)]);
    }
}
