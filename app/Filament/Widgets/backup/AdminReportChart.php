<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AdminReportChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Status Laporan';
    public function getDescription(): ?string
    {
        return 'Menampilkan Grafik jumlah laporan berdasarkan statusnya, Menunggu Persetujuan, Diterima, dan Ditolak.';
    }
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        $denied = Report::where('status', 2)->count();
        $completed = Report::where('status', 1)->count();
        $inProgress = Report::where('status', 0)->count();

        return [
            'labels' => ['Menunggu Persetujuan', 'Diterima', 'Ditolak'],
            'datasets' => [
                [
                    'label' => 'Status Laporan',
                    'data' => [$inProgress, $completed, $denied],
                    'backgroundColor' => [
                        'rgba(251, 146, 60, 0.5)',
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(239, 68, 68, 0.5)',
                    ],
                    'borderRadius' => 5,
                    'borderWidth' => 0,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // ✅ Pastikan ini diterapkan di getOptions()
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => ['beginAtZero' => true],
            ],
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
