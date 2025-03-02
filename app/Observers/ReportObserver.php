<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportCreatedNotification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        // Ambil semua user dengan role 'Administrator'
        $admins = User::role('Administrator')->get();

        // Kirim notifikasi ke setiap Administrator
        foreach ($admins as $admin) {
            Notification::make()
                ->title('Laporan Baru')
                ->info()
                ->body("Laporan \"{$report->title}\" telah dibuat oleh {$report->user->name}.")
                ->actions([
                    Action::make('view')
                        ->label('Lihat')
                        ->url(\App\Filament\Resources\ReportResource::getUrl('edit', ['record' => $report->id]), shouldOpenInNewTab: false)
                        ->link(),
                ])
                ->sendToDatabase($admin);
        }
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        // Cek apakah status berubah
        if ($report->wasChanged('status')) {
            // Ambil pengguna yang mengunggah laporan
            $user = $report->user;

            // Kirim notifikasi ke user yang mengunggah laporan
            Notification::make()
                ->title('Status Laporan Diperbarui')
                ->success()
                ->body("Laporan {$report->title} telah diperbarui statusnya menjadi " . $this->getStatusText($report->status) . " .")
                ->actions([
                    Action::make('edit')
                        ->label('Ubah Laporan')
                        ->url(\App\Filament\Resources\ReportResource::getUrl('edit', ['record' => $report->id]), shouldOpenInNewTab: false)
                        ->link(),
                ])
                ->sendToDatabase($user);
        }

        // Hapus pengajuan edit yang telah disetujui jika bukan Administrator
        if (!Auth::user()->hasRole('Administrator')) {
            $deletedRequests = $report->reportEditRequests()
                ->where('user_id', Auth::id())
                ->where('status', 1) // Hanya hapus request yang disetujui
                ->get(); // Ambil request yang akan dihapus

            if ($deletedRequests->isNotEmpty()) {
                // Simpan informasi user yang menghapus pengajuan
                $userName = Auth::user()->name;

                // Hapus pengajuan edit yang sudah disetujui
                $report->reportEditRequests()
                    ->where('user_id', Auth::id())
                    ->where('status', 1)
                    ->delete();

                // Kirim notifikasi ke semua Administrator
                $admins = User::role('Administrator')->get(); // Ambil semua admin

                Notification::make()
                    ->title("{$userName} Memperbarui Laporan")
                    ->info()
                    ->body("{$userName} telah memperbarui laporan \"{$report->title}\", dari pengajuan permohonan perubahan yang disetujui sebelumnya.")
                    ->sendToDatabase($admins);
            }
        }
    }

    private function getStatusText($status): string
    {
        return match ((string) $status) {
            '0' => 'Menunggu Persetujuan',
            '1' => 'Diterima',
            '2' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
