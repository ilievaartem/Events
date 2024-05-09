<?php

namespace App\Factory\Message;

use App\Constants\Request\MessageRequestConstants;
use App\DTO\Message\CreateMessageDTO;
use Illuminate\Http\Request;

class CreateMessageDTOFactory
{
    public function make(Request $request, string $eventId, string $responderId): CreateMessageDTO
    {
        return new CreateMessageDTO(
            eventId: $eventId,
            responderId: $responderId,
            receiverId: $request->input(MessageRequestConstants::RECEIVER_ID),
            text: $request->input(MessageRequestConstants::TEXT),
        );
    }
}
