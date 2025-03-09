<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LatestReport extends BaseWidget
{
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading(Auth::user()->hasRole('Administrator') ? 'Laporan Terbaru' : 'Laporan Anda')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date(),

                TextColumn::make('user.name')
                    ->label('Kontraktor')
                    ->visible(Auth::user()->hasRole('Administrator')),

                TextColumn::make('ReportType.name')
                    ->label('Laporan')
                    ->limit(Auth::user()->hasRole('Administrator') ? 15 : null),

                TextColumn::make('status')
                    ->label('Status Laporan')
                    ->badge()
                    ->color(fn(string $state): string => match ((string) $state) {
                        '0' => 'warning',
                        '1' => 'success',
                        '2' => 'danger',
                        default => 'Tidak Diketahui',
                    })
                    ->formatStateUsing(fn(string $state): string => match ((string) $state) {
                        '0' => 'Menunggu Persetujuan',
                        '1' => 'Diterima',
                        '2' => 'Ditolak',
                        default => 'Tidak Diketahui',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        '0' => 'heroicon-o-clock',
                        '1' => 'heroicon-o-document-check',
                        '2' => 'heroicon-o-document-minus',
                    }),
            ])
            ->defaultSort('status', 'asc') // Urutkan status (Dalam Proses -> Selesai)
            ->defaultSort('created_at', 'desc'); // Jika status sama, urutkan berdasarkan tanggal terbaru
    }

    private function getQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('Administrator')) {
            return Report::query();
        }

        if ($user->hasRole('Kontraktor')) {
            return Report::query()->where('user_id', $user->id);
        }

        return Report::query()->where('user_id', $user->id); // Default untuk user biasa
    }
}
