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

    public function formatViewResponse(array $values, ?array $filter = null): ?array
    {
        $paginator = $values;
        unset($paginator['data']);
        return[
            'content' => $values['data'],
            'paginator' => $paginator,
            'filter' => $filter
        ];
    }
}
