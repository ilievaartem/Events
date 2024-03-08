<?php

namespace App\Http\Controllers;

use App\Constants\Request\MediaRequestConstants;
use App\Factory\Media\UploadCommentMediaDTOFactory;
use App\Http\Requests\Media\MediaCreateRequest;
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

    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->mediaService->delete($id)]);
    }
    public function addPhotos(
        MediaCreateRequest $request,
        UploadCommentMediaDTOFactory $uploadCommentMediaDTOFactory,
        string $id
    ) {
        $createDTOPhotos = $uploadCommentMediaDTOFactory->make($request, $id);

        return response()->json(
            $this->mediaService->uploadPhotos(
                $id,
                $createDTOPhotos
            )
        );
    }
}
