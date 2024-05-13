<?php

namespace App\Factory\Calculate;

use App\Constants\Request\CalculationRequestConstants;
use App\DTO\Calculate\CalculationDTO;
use Illuminate\Http\Request;

class CalculationDTOFactory
{
    public function make(Request $request): CalculationDTO
    {
        return new CalculationDTO(
            operation: $request->input(CalculationRequestConstants::OPERATION),
            operands: $request->input(CalculationRequestConstants::OPERANDS),
        );
    }
}
