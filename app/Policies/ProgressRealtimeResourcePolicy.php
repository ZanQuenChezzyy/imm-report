<?php

namespace App\Policies;

use App\Models\ProgressRealtime;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProgressRealtimeResourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Progress');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProgressRealtime $progressRealtime): bool
    {
        return $user->can('View Progress');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Create Progress');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProgressRealtime $progressRealtime): bool
    {
        return $user->can('Update Progress');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProgressRealtime $progressRealtime): bool
    {
        return $user->can('Delete Progress');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProgressRealtime $progressRealtime): bool
    {
        return $user->can('Restore Progress');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProgressRealtime $progressRealtime): bool
    {
        return $user->can('Force Delete Progress');
    }
}
