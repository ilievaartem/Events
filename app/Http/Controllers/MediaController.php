<?php

namespace App\Http\Controllers;

use App\Constants\Request\MediaRequestConstants;
use App\Factory\Media\UploadCommentMediaDTOFactory;
use App\Http\Requests\Media\MediaCreateRequest;
use App\Services\AuthWrapperService;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(
        private MediaService $mediaService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }

    public function show(string $id): JsonResponse
    {
        return response()->json($this->mediaService->show($id));
    }
    public function getCommentMedia(string $commentId): JsonResponse
    {
        return response()->json($this->mediaService->getCommentMedia($commentId));
    }
    public function getEventMedia(string $eventId): JsonResponse
    {
        return response()->json($this->mediaService->getEventMedia($eventId));
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
                $this->authWrapperService->getAuthIdentifier(),
                $createDTOPhotos
            )
        );
    }
}
