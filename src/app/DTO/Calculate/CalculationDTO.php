<?php

namespace App\DTO\Calculate;

class CalculationDTO
{
    public function __construct(
        private readonly string $operation,
        private readonly array $operands,
    )
    {
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getOperands(): array
    {
        return $this->operands;
    }
}
