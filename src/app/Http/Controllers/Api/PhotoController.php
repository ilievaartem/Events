<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function show($photoName)
    {
        $filePath = 'icons/' . $photoName . '.svg';

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Фото не знайдено'], 404);
        }

        return Storage::disk('public')->download($filePath, $photoName . '.svg');
    }
}
