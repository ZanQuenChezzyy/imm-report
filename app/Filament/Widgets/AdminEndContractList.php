<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AdminEndContractList extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Contract::query()
            ->where('status', 1) // Hanya kontrak aktif
            ->whereBetween('period_end', [now(), now()->addMonths(6)]) // Kontrak yang habis dalam 6 bulan
            ->orderBy('period_end', 'asc'); // Urutkan berdasarkan tanggal habis
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->heading('Reminder Kontrak Yang Akan Habis')
            ->description('Daftar kontrak yang akan berakhir dalam 6 bulan ke depan. Pastikan untuk melakukan perpanjangan atau tindak lanjut jika diperlukan.')
            ->emptyStateHeading('Tidak Ada Kontrak yang Akan Habis')
            ->emptyStateDescription('Saat ini tidak ada kontrak yang akan berakhir dalam 6 bulan ke depan.')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Kontraktor'),

                TextColumn::make('number')
                    ->label('Nomor Kontrak'),

                TextColumn::make('sisa_waktu') // Alias supaya tidak bentrok dengan period_end
                    ->label('Sisa Waktu')
                    ->badge()
                    ->state(fn($record) => $this->hitungSisaWaktu($record->period_end)) // Hitung sisa waktu
                    ->color(fn($record) => now()->diffInDays($record->period_end) <= 90 ? 'danger' : 'warning'),

                TextColumn::make('period_end_date') // Alias untuk menghindari bentrok
                    ->label('Tanggal Berakhir')
                    ->state(fn($record) => $record->period_end) // Gunakan state() agar tetap terbaca
                    ->date('d M Y'),
            ]);
    }

    private function hitungSisaWaktu($periodEnd): string
    {
        $now = now();
        $diff = $now->diff($periodEnd);

        $sisaBulan = $diff->m; // Ambil sisa bulan
        $sisaHari = $diff->d; // Ambil sisa hari

        if ($sisaBulan == 0) {
            return "$sisaHari Hari";
        }
        return "$sisaBulan Bulan $sisaHari Hari";
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Administrator');
    }
}
