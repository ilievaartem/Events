<?php

namespace App\Repositories;

use App\Constants\DB\ChatDBConstants;
use App\Constants\DB\MessageDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Event;
use App\Repositories\Interfaces\ChatRepositoryInterface;

class ChatRepository extends BaseRepository implements ChatRepositoryInterface
{
    public function getChatAuthorByChatId(string $chatId): ?string
    {
        return $this->model->query()->where(ChatDBConstants::ID, $chatId)->first()->author_id;
    }
    public function getChatMemberByChatId(string $chatId): ?string
    {
        return $this->model->query()->where(ChatDBConstants::ID, $chatId)->first()->member_id;
    }
    public function getAllAuthorChat(string $authorId): ?array
    {
        return $this->model->query()->where(ChatDBConstants::AUTHOR_ID, $authorId)
            ->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function getAllMemberChat(string $memberId): ?array
    {
        return $this->model->query()->where(ChatDBConstants::MEMBER_ID, $memberId)
            ->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function getChatWithAllMessages(string $chatId): array
    {
        return $this->model->query()
            ->select(
                    // ChatDBConstants::TABLE . '.' . ChatDBConstants::AUTHOR_ID,
                    // ChatDBConstants::TABLE . '.' . ChatDBConstants::MEMBER_ID,
                MessageDBConstants::TABLE . '.*'
            )
            ->join(
                MessageDBConstants::TABLE,
                ChatDBConstants::TABLE . '.' . ChatDBConstants::ID,
                '=',
                MessageDBConstants::TABLE . '.' . MessageDBConstants::CHAT_ID
            )
            ->where(ChatDBConstants::TABLE . '.' . ChatDBConstants::ID, '=', $chatId)
            ->orderBy(MessageDBConstants::TABLE . '.' . MessageDBConstants::CREATED_AT, 'asc')
            ->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsChatExistById(string $chatId): bool
    {
        return $this->model->query()->where(ChatDBConstants::ID, $chatId)->exists();
    }
    public function getChatId(string $eventId, string $authorId, string $memberId): ?string
    {
        return $this->model->query()->select(ChatDBConstants::ID)->where(ChatDBConstants::AUTHOR_ID, $authorId)
            ->where(ChatDBConstants::MEMBER_ID, $memberId)
            ->where(ChatDBConstants::EVENT_ID, $eventId)
            ->first()->id;
    }
    public function checkIsChatExist(string $eventId, string $authorId, string $memberId): bool
    {
        return $this->model->query()->where(ChatDBConstants::EVENT_ID, $eventId)
            ->where(ChatDBConstants::MEMBER_ID, $memberId)->where(ChatDBConstants::AUTHOR_ID, $authorId)->exists();
    }
}
