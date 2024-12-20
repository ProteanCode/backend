<?php

namespace App\Observers;

use App\Enums\NftCardStatus;
use App\Models\NftCard;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        Log::info('Created media');
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void
    {
        if ($media->model_type === NftCard::class) {
            $media->model->status = NftCardStatus::ACTIVE->value;
        }
    }
}
