<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AdminContractChart extends ChartWidget
{
    protected static ?string $heading = 'Status Kontrak';

    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';

    public function getDescription(): ?string
    {
        return 'Menampilkan grafik kontrak yang masih berjalan dan kontrak yang telah selesai atau tidak aktif.';
    }

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $tahun = $this->filters['tahun'] ?? date('Y');

        $activeContracts = Contract::where('status', 1)
            ->whereYear('period_end', $tahun)
            ->count();

        $inactiveContracts = Contract::where('status', 0)
            ->whereYear('period_end', $tahun)
            ->count();

        return [
            'datasets' => [
                [
                    'data' => [$activeContracts, $inactiveContracts],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(239, 68, 68, 0.5)',
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

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false, // Menghilangkan legend (label + kotak)
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
