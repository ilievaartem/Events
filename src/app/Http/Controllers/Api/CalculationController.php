<?php

namespace App\Http\Controllers\Api;

use App\Factory\Calculate\CalculationDTOFactory;
use App\Http\Requests\Calculation\CalculationRequest;
use App\Services\CalculationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function __construct(private readonly CalculationService $calculationService)
    {

    }

    public function calculate(CalculationRequest $request, CalculationDTOFactory $calculationDTOFactory): JsonResponse
    {
        return response()->json($this->calculationService->performCalculation($calculationDTOFactory->make($request)));
    }
}
