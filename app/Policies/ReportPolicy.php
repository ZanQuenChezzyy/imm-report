<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('View Any Report');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Report $report): bool
    {
        return $user->can('View Report');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Create Report');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Report $report): bool
    {
        // Jika user adalah Administrator, izinkan edit tanpa batasan
        if ($user->hasRole('Administrator')) {
            return true;
        }

        // Jika status laporan bukan 0, user tidak bisa mengedit
        if ($report->status === 0) {
            return true;
        }

        // Cek apakah user adalah pemilik report
        if ($report->user_id === $user->id) {
            // Ambil pengajuan edit terakhir dari user untuk report ini
            $latestRequest = $report->reportEditRequests()
                ->where('user_id', $user->id)
                ->latest() // Ambil yang terbaru
                ->first();

            // Jika user belum pernah mengajukan edit, tolak edit
            if (!$latestRequest) {
                return false;
            }

            // Jika status pengajuan terakhir diterima, izinkan edit
            if ($latestRequest->status === 1) {
                return true;
            }

            // Jika status masih pending atau ditolak, tolak edit
            return false;
        }

        // Jika bukan pemilik laporan, default ke false (tidak bisa edit)
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->can('Delete Report');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Report $report): bool
    {
        return $user->can('Restore Report');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return $user->can('Force Delete Report');
    }
}
