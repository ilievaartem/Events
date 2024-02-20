<?php

namespace App\Http\Requests\Complaints;

use App\Constants\Request\ComplaintRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ComplaintRequestConstants::PHRASE => 'nullable|string|min:1|max:255',
            ComplaintRequestConstants::AUTHOR_ID => 'nullable|string|uuid',
            ComplaintRequestConstants::EVENT_ID => 'nullable|string|uuid',
            ComplaintRequestConstants::CAUSE_MESSAGE => 'nullable|string|min:1|max:255',
            ComplaintRequestConstants::CAUSE_DESCRIPTION => 'nullable|string|min:30|max:1055',
            ComplaintRequestConstants::RESOLVE_MESSAGE => 'nullable|string|min:1|max:255',
            ComplaintRequestConstants::RESOLVE_DESCRIPTION => 'nullable|string|min:30|max:1055',
            ComplaintRequestConstants::RESOLVER_ID => 'nullable|string|uuid',
            ComplaintRequestConstants::RESOLVED_FROM => 'nullable|date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::RESOLVED_TO => 'nullable|date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::READ_FROM => 'nullable|date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::READ_TO => 'nullable|date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::CREATED_FROM => 'nullable|date_format:Y-m-d H:i:s',
            ComplaintRequestConstants::CREATED_TO => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
