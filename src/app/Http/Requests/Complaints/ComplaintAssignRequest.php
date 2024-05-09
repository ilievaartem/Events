<?php

namespace App\Http\Requests\Complaints;

use App\Constants\Request\ComplaintRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintAssignRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            ComplaintRequestConstants::ASSIGNEE => 'string|uuid',
        ];
    }
}
