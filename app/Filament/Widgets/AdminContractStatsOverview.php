<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminContractStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activeContracts = Contract::where('status', 1)->count();
        $inactiveContracts = Contract::where('status', 0)->count();
        $expiringContracts = Contract::where('status', 1)
            ->whereBetween('period_end', [now(), now()->addMonths(6)])
            ->count();

        return [
            Stat::make('Kontrak Aktif', $activeContracts)
                ->description('Jumlah kontrak yang masih berjalan.')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Kontrak Tidak Aktif', $inactiveContracts)
                ->description('Jumlah kontrak yang Tidak Aktif.')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Kontrak yang Akan Berakhir', $expiringContracts)
                ->description('Kontrak yang akan habis dalam 6 bulan.')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
