<?php

namespace App\Http\Requests\Complaints;

use App\Constants\Request\ComplaintRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            ComplaintRequestConstants::PHRASE => 'string|min:1|max:255',
            ComplaintRequestConstants::AUTHOR_ID => 'string|uuid',
            ComplaintRequestConstants::EVENT_ID => 'string|uuid',
            ComplaintRequestConstants::SEARCH_BY . '.*' => 'string|in:' .
                ComplaintRequestConstants::CAUSE_MESSAGE . ',' .
                ComplaintRequestConstants::RESOLVE_MESSAGE,
            ComplaintRequestConstants::RESOLVER_ID => 'string|uuid',
            ComplaintRequestConstants::RESOLVED_FROM => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::RESOLVED_TO => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::READ_FROM => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::READ_TO => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::CREATED_FROM => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::CREATED_TO => 'date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::SEARCH . '.*' => 'string|in:' .
                ComplaintRequestConstants::CAUSE_MESSAGE . ',' .
                ComplaintRequestConstants::CAUSE_DESCRIPTION,
        ];
    }
}
