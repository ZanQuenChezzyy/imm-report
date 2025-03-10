<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Reminder';
    protected static ?string $navigationGroup = 'Kelola Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';
    protected static ?string $activeNavigationIcon = 'heroicon-s-calendar-date-range';
    protected static ?int $navigationSort = 21;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereBetween('period_end', [now(), now()->addMonths(6)])->count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'info' : 'danger';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Kontrak Akan Habis';
    protected static ?string $slug = 'reminder';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Nama Pengguna')
                    ->relationship('user', 'name')
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->default(fn($livewire) => $livewire->ownerRecord?->id)
                    ->hidden()
                    ->dehydratedWhenhidden()
                    ->required(),

                Select::make('company_id')
                    ->label('Perusahaan Pembuat Kontrak')
                    ->relationship('company', 'name')
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->required(),

                TextInput::make('number')
                    ->label('Nomor Kontrak')
                    ->placeholder('Masukkan Nomor Kontrak')
                    ->minLength(5)
                    ->maxLength(45)
                    ->required(),

                TextInput::make('name')
                    ->label('Nama Kontrak')
                    ->placeholder('Masukkan Nama Kontrak')
                    ->minLength(5)
                    ->maxLength(45)
                    ->required(),

                DatePicker::make('period_start')
                    ->label('Tanggal Mulai')
                    ->placeholder('Pilih Tanggal Mulai')
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $now = now();
                        $start = $get('period_start');
                        $end = $get('period_end');

                        if ($start && $end) {
                            $set('status', ($now->between($start, $end)) ? '1' : '0');
                        } else {
                            $set('status', '0');
                        }
                    })
                    ->required(),

                DatePicker::make('period_end')
                    ->label('Tanggal Selesai')
                    ->placeholder('Pilih Tanggal Selesai')
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $now = now();
                        $start = $get('period_start');
                        $end = $get('period_end');

                        if ($start && $end) {
                            $set('status', ($now->between($start, $end)) ? '1' : '0');
                        } else {
                            $set('status', '0');
                        }
                    })
                    ->required(),

                Repeater::make('contractFiles')
                    ->label('Lampiran (Jika Ada)')
                    ->relationship('contractFiles')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('')
                            ->nullable(),
                    ])
                    ->addActionLabel('Tambah Lampiran')
                    ->columnSpanFull()
                    ->grid(2),

                Select::make('status')
                    ->label('Status Kontrak')
                    ->placeholder('Pilih Status Kontrak')
                    ->options([
                        '0' => 'Tidak Aktif',
                        '1' => 'Aktif'
                    ])
                    ->native(false)
                    ->hidden()
                    ->dehydratedWhenHidden()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn(Builder $query) =>
                $query->where('status', 1) // Hanya kontrak aktif
                    ->whereBetween('period_end', [now(), now()->addMonths(6)]) // Kontrak habis dalam 6 bulan
                    ->orderBy('period_end', 'asc')
            )
            ->heading('Reminder Kontrak Yang Akan Habis')
            ->description('Daftar kontrak yang akan berakhir dalam 6 bulan ke depan. Pastikan untuk melakukan perpanjangan atau tindak lanjut jika diperlukan.')
            ->emptyStateHeading('Tidak Ada Kontrak yang Akan Habis')
            ->emptyStateDescription('Saat ini tidak ada kontrak yang akan berakhir dalam 6 bulan ke depan.')
            ->columns([
                TextColumn::make('number')
                    ->label('Nomor'),

                TextColumn::make('user.name')
                    ->label('Kontraktor'),

                TextColumn::make('company.name')
                    ->label('Perusahaan'),

                TextColumn::make('name')
                    ->label('Nama Kontrak'),

                TextColumn::make('period_start')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->sortable(),

                TextColumn::make('period_end')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),

                TextColumn::make('sisa_waktu')
                    ->label('Sisa Waktu')
                    ->badge()
                    ->state(fn($record) => self::hitungSisaWaktu($record->period_end)) // Panggil fungsi statis
                    ->color(fn($record) => now()->diffInDays($record->period_end) <= 90 ? 'danger' : 'warning'),
            ])
            ->filters([
                SelectFilter::make('period_end')
                    ->label('Sisa Waktu')
                    ->placeholder('Pilih Sisa Waktu')
                    ->options([
                        '1' => '≤ 1 Bulan',
                        '2' => '≤ 2 Bulan',
                        '3' => '≤ 3 Bulan',
                        '6' => '≤ 6 Bulan',
                    ])
                    ->query(function (Builder $query, $data) {
                        if (!isset($data['value'])) {
                            return;
                        }
                        $months = (int) $data['value'];
                        $query->whereBetween('period_end', [now(), now()->addMonths($months)]);
                    })
                    ->native(false),


            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->hidden(),
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(),
                ])
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->color('info')
                    ->tooltip('Aksi')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContracts::route('/'),
        ];
    }

    private static function hitungSisaWaktu($periodEnd): string
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

}
