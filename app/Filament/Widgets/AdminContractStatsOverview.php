<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminContractStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $tahun = $this->filters['tahun'] ?? date('Y');

        $TotalContractor = User::role('Kontraktor')->count();
        $inactiveContracts = Contract::where('status', 0)
            ->whereYear('period_end', $tahun)
            ->count();

        $expiringContracts = Contract::where('status', 1)
            ->whereYear('period_end', $tahun)
            ->whereBetween('period_end', [now(), now()->addMonths(6)])
            ->count();

        return [
            Stat::make('Total Kontraktor', $TotalContractor)
                ->description('Jumlah kontraktor terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Kontrak yang Akan Berakhir', $expiringContracts)
                ->description("Kontrak yang akan habis di tahun $tahun")
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Kontrak Selesai', $inactiveContracts)
                ->description("Jumlah kontrak yang selesai di tahun $tahun")
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
