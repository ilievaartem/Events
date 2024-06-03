<?php

namespace App\Factory\Dashboard;

use App\DTO\Dashboard\DashboardDTO;
use Illuminate\Http\Request;

class DashboardDTOFactory
{
    public function make(Request $request): DashboardDTO
    {
        return new DashboardDTO(
            events: $request->query('events'),
            tags: $request->query('tags'),
            users: $request->query('users'),
            categories: $request->query('categories'),
        );
    }
}
