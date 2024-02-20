<?php

namespace App\Services\System;

class DataFormattersService
{
    public static function formatValuesToInt(?array $values): ?array
    {
        if ($values != null) {
            return array_map('intval', $values);
        }
        return $values;
    }
}
