<?php

namespace App\Factory\Complaint;

use App\Constants\Request\ComplaintRequestConstants;
use App\DTO\Complaint\FilterComplaintDTO;
use Illuminate\Http\Request;

class FilterComplaintDTOFactory
{
    public function make(Request $request): FilterComplaintDTO
    {
        return new FilterComplaintDTO(
            phrase: $request->input(ComplaintRequestConstants::PHRASE),
            authorId: $request->input(ComplaintRequestConstants::AUTHOR_ID),
            eventId: $request->input(ComplaintRequestConstants::EVENT_ID),
            assignee: $request->input(ComplaintRequestConstants::ASSIGNEE),
            searchBy: $request->input(ComplaintRequestConstants::SEARCH_BY) != null
            ? array_flip($request->input(ComplaintRequestConstants::SEARCH_BY))
            : $request->input(ComplaintRequestConstants::SEARCH_BY),
            resolverId: $request->input(ComplaintRequestConstants::RESOLVER_ID),
            resolvedFrom: $request->input(ComplaintRequestConstants::RESOLVED_FROM),
            resolvedTo: $request->input(ComplaintRequestConstants::RESOLVED_TO),
            readFrom: $request->input(ComplaintRequestConstants::READ_FROM),
            readTo: $request->input(ComplaintRequestConstants::READ_TO),
            createdFrom: $request->input(ComplaintRequestConstants::CREATED_FROM),
            createdTo: $request->input(ComplaintRequestConstants::CREATED_TO),
        );
    }
}
