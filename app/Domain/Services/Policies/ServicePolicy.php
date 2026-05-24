<?php

namespace App\Domain\Services\Policies;

use App\Domain\Businesses\Models\Business;
use App\Domain\Services\Models\Service;
use App\Domain\Users\Models\User;

class ServicePolicy
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
    public function view(User $user, Service $service): bool
    {
        return $service->is_active;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,Business $business): bool
    {
        return $business->owner_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        return $this->ownsService($user, $service);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        return $this->ownsService($user, $service);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return $this->ownsService($user, $service);
    }

    private function ownsService(
        User $user,
        Service $service
    ): bool {
        return $user->id === $service->business->owner_id;
    }
}
