<?php

namespace App\Factory\Complaint;

use App\Constants\Content\ComplaintsConstant;
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
//            resolverId: $this->authWrapperService->getAuthIdentifier(),
            resolverId: '9bd1eb36-1426-4350-aec4-1a8d66204a79',
            resolveMessage: $request->input(ComplaintsConstant::RESOLVE_MESSAGES),
            resolveDescription: $request->input(ComplaintRequestConstants::RESOLVE_DESCRIPTION),
        );
    }
}
