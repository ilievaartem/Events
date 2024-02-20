<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileRepository
{

    public function save(string $directory, string $photo): void
    {
        Storage::disk('local')->put($directory, $photo);
    }
    public function delete(string $filePath): void
    {
        Storage::disk('local')->delete($filePath);
    }
    public function deleteMany(array $filePaths): void
    {
        Storage::disk('local')->delete($filePaths);
    }
}
