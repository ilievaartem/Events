<?php

namespace App\Http\Controllers;

use App\Constants\Request\MediaRequestConstants;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->mediaService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->mediaService->show($id));
    }
    public function create(Request $request, string $commentId): JsonResponse
    {
        $photo = $request->file(MediaRequestConstants::PHOTO);
        $photoExtension = $request->file(MediaRequestConstants::PHOTO)->extension();
        return response()->json($this->mediaService->create($commentId, $photo, $photoExtension));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $photo = $request->file(MediaRequestConstants::PHOTO);
        $photoExtension = $request->file(MediaRequestConstants::PHOTO)->extension();
        return response()->json($this->mediaService->updatePhoto($id, $photo, $photoExtension));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json($this->mediaService->delete($id));

    }
}
