<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use App\Models\Report;
use App\Models\ReportEditRequest;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ContractorStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $contractorId = auth()->id();
        $activeContracts = Contract::where('user_id', $contractorId)
            ->where('status', 1)
            ->get(['period_end']);

        $totalActiveContracts = $activeContracts->count();
        $expirationDates = $activeContracts->map(function ($contract) {
            return $contract->period_end
                ? Carbon::parse($contract->period_end)->format('d M Y')
                : 'Tidak ada tanggal';
        })->implode(', ');

        return [
            Stat::make('Total Kontrak yang Dimiliki', Contract::where('user_id', $contractorId)->count())
                ->description('Jumlah kontrak yang Anda Miliki.')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Total Laporan yang Dibuat', Report::where('user_id', $contractorId)->count())
                ->description('Jumlah laporan yang telah dikirim.')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('success'),

            Stat::make('Total Permintaan Edit Laporan', ReportEditRequest::where('user_id', $contractorId)->count())
                ->description('Jumlah permintaan edit laporan yang diajukan.')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('warning'),

            Stat::make('Kontrak Aktif', $totalActiveContracts)
                ->description($totalActiveContracts > 0
                    ? "Kontrak Akan kedaluwarsa pada: $expirationDates"
                    : 'Tidak ada kontrak aktif saat ini.')
                ->descriptionIcon('heroicon-o-clock')
                ->color($totalActiveContracts > 0 ? 'info' : 'gray'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Kontraktor');
    }
}
