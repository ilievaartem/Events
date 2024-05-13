<?php

namespace App\Services;

use App\DTO\Calculate\CalculationDTO;

class CalculationService
{
//    public function __construct(
//        CalculationRepositoryInterface $repository,
//    )
//    {
//        parent::__construct($repository);
//    }

    public function performCalculation(CalculationDTO $calculationDTO): ?int
    {
        $operation = $calculationDTO->getOperation();

        switch ($operation) {
            case 'sum':
                return $this->sumOfArray($calculationDTO->getOperands());
            case 'max':
                return $this->maxOfArray($calculationDTO->getOperands());
            case 'min':
                return $this->minOfArray($calculationDTO->getOperands());
            default:
                abort(400, 'Invalid operation');
        }
    }

    private function maxOfArray(array $arguments): ?int
    {
        $maxNumber = null;

        foreach ($arguments as $key => $argument) {
            if (is_int($argument)) {
                if ($key == 0) {
                    $maxNumber = $argument;
                }
                if ($argument > $maxNumber) {
                    $maxNumber = $argument;
                }
            } elseif (is_array($argument)) {
                $maxNumberInArray = $this->maxOfArray($argument);
                if (empty($maxNumber) || $maxNumberInArray > $maxNumber) {
                    $maxNumber = $maxNumberInArray;
                }
            }
        }
        return $maxNumber;
    }

    private function minOfArray(array $arguments): ?int
    {
        $minNumber = null;

        foreach ($arguments as $key => $argument) {
            if (is_int($argument)) {
                if ($key == 0) {
                    $minNumber = $argument;
                }
                if ($argument < $minNumber) {
                    $minNumber = $argument;
                }
            } elseif (is_array($argument)) {
                $minNumberInArray = $this->minOfArray($argument);
                if (empty($minNumber) || ($minNumberInArray < $minNumber && $minNumberInArray !== null)) {
                    $minNumber = $minNumberInArray;
                }
            }
        }
        return $minNumber;
    }

    private function sumOfArray(array $arguments): ?int
    {
        $sumNumber = null;

        foreach ($arguments as $argument) {
            if (is_int($argument)) {
                $sumNumber += $argument;
            }
            elseif (is_array($argument)) {
                $sumNumberInArray = $this->sumOfArray($argument);
                if (empty($sumNumber)) {
                    $sumNumber = $sumNumberInArray;
                } else {
                    $sumNumber += $sumNumberInArray;
                }
            }
        }
        return $sumNumber;
    }
}
