<?php

namespace App\Jobs;

use App\Services\PhotoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteSinglePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $oldPath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PhotoService $photoService): void
    {
        $photoService->deleteOldPhoto($this->oldPath);
    }
}
