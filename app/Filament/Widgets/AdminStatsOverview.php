<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Report;
use App\Models\ReportEditRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::count())
                ->description('Jumlah pengguna terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Total Kontraktor', User::role('Kontraktor')->count()) // Menggunakan Spatie Role
                ->description('Jumlah kontraktor terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Total Perusahaan', Company::count())
                ->description('Jumlah perusahaan yang terdaftar')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info'),

            Stat::make('Total Kontrak Aktif', Contract::where('status', 1)->count())
                ->description('Kontrak yang masih berjalan')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('warning'),

            Stat::make('Total Laporan', Report::count())
                ->description('Jumlah laporan yang masuk')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('secondary'),

            Stat::make('Permintaan Edit Laporan', ReportEditRequest::where('status', 0)->count())
                ->description('Jumlah permintaan edit yang pending')
                ->descriptionIcon('heroicon-o-pencil')
                ->color('danger'),
        ];
    }
    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
