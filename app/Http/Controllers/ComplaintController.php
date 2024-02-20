<?php


namespace App\Http\Controllers;

use App\Constants\Request\ComplaintRequestConstants;

use App\DTO\Complaint\FilterComplaintDTO;
use App\Http\Requests\Complaints\ComplaintFilterRequest;
use App\Services\ComplaintService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function __construct(private ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->complaintService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->complaintService->show($id));
    }
    public function filter(ComplaintFilterRequest $request): JsonResponse
    {

        $filterComplaintDTO = new FilterComplaintDTO(

            phrase: $request->input(ComplaintRequestConstants::PHRASE),
            authorId: $request->input(ComplaintRequestConstants::AUTHOR_ID),
            eventId: $request->input(ComplaintRequestConstants::EVENT_ID),
            causeMessage: $request->input(ComplaintRequestConstants::CAUSE_MESSAGE),
            searchByCauseDescription: $request->input(ComplaintRequestConstants::CAUSE_DESCRIPTION),
            resolveMessage: $request->input(ComplaintRequestConstants::RESOLVE_MESSAGE),
            searchByResolveDescription: $request->input(ComplaintRequestConstants::RESOLVE_DESCRIPTION),
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
        $authorId = auth()->user()->getAuthIdentifier();
        $causeMessage = $request->input(ComplaintRequestConstants::CAUSE_MESSAGE);
        $causeDescription = $request->input(ComplaintRequestConstants::CAUSE_DESCRIPTION);
        return response()->json($this->complaintService->create($eventId, $authorId, $causeMessage, $causeDescription));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $authorId = auth()->user()->getAuthIdentifier();
        $resolveMessage = $request->input(ComplaintRequestConstants::RESOLVE_MESSAGE);
        $resolveDescription = $request->input(ComplaintRequestConstants::RESOLVE_DESCRIPTION);
        return response()->json($this->complaintService->update($id, $authorId, $resolveMessage, $resolveDescription));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json($this->complaintService->delete($id));

    }
}
