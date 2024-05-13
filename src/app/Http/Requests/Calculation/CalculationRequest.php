<?php

namespace App\Http\Requests\Calculation;

use App\Constants\Request\CalculationRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CalculationRequestConstants::OPERATION => 'required|string|in:sum,max,min',
            CalculationRequestConstants::OPERANDS => 'required|array',
        ];
    }

}
