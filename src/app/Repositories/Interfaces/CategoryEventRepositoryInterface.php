<?php

namespace App\Repositories\Interfaces;

interface CategoryEventRepositoryInterface
{
    public function getEventsIdByCategories(array $categoriesIds): array;

}
