<?php

namespace App\Http\Requests\Places;

use App\Constants\Request\PlaceRequestConstants;
use App\Services\PlaceService;
use Illuminate\Foundation\Http\FormRequest;

class PlaceCreateRequest extends FormRequest
{
    public function __construct(
        private PlaceService $placeService,
    ) {
    }
    public function rules(): array
    {
        return [
            PlaceRequestConstants::NAME => 'required|min:1|max:100|string',
            PlaceRequestConstants::TYPE => 'required|string|in:' . $this->placeService->getPlaceTypeList(),
            PlaceRequestConstants::COMMUNITY_ID => 'required|integer|min:0'
        ];
    }
}
