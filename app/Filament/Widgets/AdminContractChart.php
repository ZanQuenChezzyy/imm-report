<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AdminContractChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Status Kontrak';

    public function getDescription(): ?string
    {
        return 'Menampilkan Grafik kontrak yang masih berjalan dan kontrak yang telah selesai atau tidak aktif.';
    }
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        // Hitung jumlah kontrak berdasarkan status
        $activeContracts = Contract::where('status', 1)->count();
        $inactiveContracts = Contract::where('status', 0)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kontrak',
                    'data' => [$activeContracts, $inactiveContracts],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(239, 68, 68, 0.5)'
                    ],
                    'borderRadius' => 10,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Aktif', 'Tidak Aktif'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
