<?php

namespace App\Policies;

use App\Models\Produksi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProduksiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isProduksi() || $user->isPemilik();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Produksi $produksi): bool
    {
        return $user->isProduksi() || $user->isPemilik();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isProduksi();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Produksi $produksi): bool
    {
        return $user->isProduksi();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Produksi $produksi): bool
    {
        return $user->isProduksi();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isProduksi();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Produksi $produksi): bool
    {
        return $user->isProduksi();
    }

    public function restoreAny(User $user): bool
    {
        return $user->isProduksi();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Produksi $produksi): bool
    {
        return $user->isProduksi();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isProduksi();
    }
}
