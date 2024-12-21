<?php

namespace App\Observers;

use App\Models\NftCard;
use App\Notifications\NftCardCreated;

class NftCardObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(NftCard $nftCard): void
    {
        $nftCard->user->notify(new NftCardCreated());
    }
}
