<?php

namespace App\Policies;

use App\Models\NftCard;
use App\Models\User;

class NftCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NftCard $nftCard): bool
    {
        return $nftCard->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NftCard $nftCard): bool
    {
        return $nftCard->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NftCard $nftCard): bool
    {
        return $nftCard->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NftCard $nftCard): bool
    {
        return $nftCard->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NftCard $nftCard): bool
    {
        return $nftCard->user_id === $user->getKey();
    }
}
