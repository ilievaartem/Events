<?php

namespace App\Constants\Content;

class ComplaintsConstant
{
    public const RESOLVE_MESSAGE_DECLINED = 'Declined';
    public const RESOLVE_MESSAGE_APPLIED = 'Applied';

    public const RESOLVE_MESSAGES = [
        self::RESOLVE_MESSAGE_DECLINED,
        self::RESOLVE_MESSAGE_APPLIED,
    ];
}
