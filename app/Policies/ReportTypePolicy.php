<?php

namespace App\Policies;

use App\Models\ReportType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Report Type');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ReportType $reportType): bool
    {
        return $user->can('View Report Type');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Create Report Type');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ReportType $reportType): bool
    {
        return $user->can('Update Report Type');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ReportType $reportType): bool
    {
        return $user->can('Delete Report Type');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ReportType $reportType): bool
    {
        return $user->can('Restore Report Type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ReportType $reportType): bool
    {
        return $user->can('Force Delete Report Type');
    }
}
