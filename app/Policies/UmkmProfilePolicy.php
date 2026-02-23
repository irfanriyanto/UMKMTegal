<?php

namespace App\Policies;

use App\Models\UmkmProfile;
use App\Models\User;

class UmkmProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, UmkmProfile $umkmProfile): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isUmkm() && !$user->umkmProfile;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UmkmProfile $umkmProfile): bool
    {
        return $user->isAdmin() || $user->id === $umkmProfile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UmkmProfile $umkmProfile): bool
    {
        return $user->isAdmin() || $user->id === $umkmProfile->user_id;
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, UmkmProfile $umkmProfile): bool
    {
        return $user->isAdmin();
    }
}
