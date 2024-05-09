<?php

namespace App\Factory\Complaint;

use App\Constants\Request\ComplaintRequestConstants;
use App\DTO\Complaint\CreateComplaintDTO;
use App\Services\AuthWrapperService;
use Illuminate\Http\Request;

class CreateComplaintDTOFactory
{
    public function __construct(
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function make(Request $request, string $eventId): CreateComplaintDTO
    {
        return new CreateComplaintDTO(
            eventId: $eventId,
            authorId: $this->authWrapperService->getAuthIdentifier(),
            causeMessage: $request->input(ComplaintRequestConstants::CAUSE_MESSAGE),
            causeDescription: $request->input(ComplaintRequestConstants::CAUSE_DESCRIPTION),
        );
    }
}
