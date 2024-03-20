<?php

namespace App\Factory\Complaint;

use App\Constants\Request\ComplaintRequestConstants;
use App\DTO\Complaint\AnswerComplaintDTO;
use App\Services\AuthWrapperService;
use Illuminate\Http\Request;

class AnswerComplaintDTOFactory
{
    public function __construct(
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function make(Request $request, string $complaintId): AnswerComplaintDTO
    {
        return new AnswerComplaintDTO(
            complaintId: $complaintId,
            resolverId: $this->authWrapperService->getAuthIdentifier(),
            resolveMessage: $request->input(ComplaintRequestConstants::RESOLVE_MESSAGE),
            resolveDescription: $request->input(ComplaintRequestConstants::RESOLVE_DESCRIPTION),
        );
    }
}
