<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static ?string $label = 'Laporan';
    protected static ?string $navigationGroup = 'Kelola Laporan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $activeNavigationIcon = 'heroicon-s-document-text';
    protected static ?int $navigationSort = 4;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Laporan';
    protected static ?string $slug = 'laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Laporan')
                    ->schema([
                        Select::make('report_type_id')
                            ->label('Tipe Laporan')
                            ->placeholder('Pilih Tipe Laporan')
                            ->relationship('reportType', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('title', \App\Models\ReportType::find($state)?->name ?? '')
                            )
                            ->required(),

                        Select::make('user_id')
                            ->label('Pengguna')
                            ->placeholder('Pilih Pengguna')
                            ->relationship('user', 'name')
                            ->default(Auth::user()->hasRole('Kontraktor') ? Auth::user()->id : null)
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->hidden(Auth::user()->hasRole('Kontraktor'))
                            ->dehydratedWhenHidden()
                            ->required(),

                        TextInput::make('title')
                            ->label('Judul')
                            ->placeholder('Judul Laporan Otomatis Terisi')
                            ->minLength(10)
                            ->maxLength(45)
                            ->disabled()
                            ->hidden(Auth::user()->hasRole('Kontraktor'))
                            ->dehydratedWhenHidden(Auth::user()->hasRole('Kontraktor'))
                            ->dehydrated()
                            ->required(),

                        Select::make('frequency')
                            ->label('Periode / Frekuensi')
                            ->placeholder('Pilih Periode / Frekuensi')
                            ->options([
                                0 => 'Harian',
                                1 => 'Mingguan',
                                2 => 'Bulanan',
                                3 => '3 Bulan',
                                4 => '6 Bulan',
                                5 => '1 Tahun',
                            ])
                            ->native(false)
                            ->preload()
                            ->searchable(),

                        DatePicker::make('period_start')
                            ->label('Tanggal Mulai')
                            ->placeholder('Pilih Tanggal Mulai')
                            ->native(false)
                            ->required(),

                        DatePicker::make('period_end')
                            ->label('Tanggal Selesai')
                            ->placeholder('Pilih Tanggal Selesai')
                            ->native(false)
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi laporan')
                            ->placeholder('Masukkan Deskripsi Laporan')
                            ->minLength(10)
                            ->rows(3)
                            ->autosize(),

                        Group::make([
                            Repeater::make('Lampiran')
                                ->label('File Laporan')
                                ->relationship('reportFiles')
                                ->schema([
                                    FileUpload::make('file_path')
                                        ->label('')
                                        ->directory('laporan')
                                        ->visibility('public')
                                        ->preserveFilenames()
                                        ->maxSize(10240)
                                        ->helperText('Ukuran file maksimal 10MB')
                                        ->openable()
                                        ->downloadable()
                                        ->required(),
                                ]),

                            Select::make('status')
                                ->label('Status')
                                ->placeholder('Pilih Status Laporan')
                                ->options([
                                    '0' => 'Menunggu Persetujuan',
                                    '1' => 'Diterima',
                                    '2' => 'Ditolak',
                                ])
                                ->native(false)
                                ->preload()
                                ->searchable()
                                ->visible(Auth::user()->hasRole('Administrator'))
                                ->default(0)
                                ->required(),
                        ]),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (!Auth::user()->hasRole('Administrator')) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->poll('10s')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date()
                    ->sortable(),

                TextColumn::make('ReportType.name')
                    ->label('Tipe Laporan')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Nama Kontraktor')
                    ->visible(Auth::user()->hasRole('Administrator'))
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->limit(20)
                    ->searchable(),

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
                    })
                    ->sortable(),

                TextColumn::make('reportEditRequests.status')
                    ->label('Status Perubahan')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        '0' => 'warning',
                        '1' => 'success',
                        '2' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        '0' => 'Menunggu Persetujuan',
                        '1' => 'Disetujui',
                        '2' => 'Ditolak',
                        default => 'Tidak Ada',
                    })
                    ->default('Tidak Ada')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('file_path')
                    ->label('File Laporan')
                    ->formatStateUsing(fn(string $state): string => pathinfo($state, PATHINFO_BASENAME))
                    ->limit(20)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('report_type_id')
                    ->label('Laporan')
                    ->placeholder('Pilih Laporan')
                    ->relationship('reportType', 'name')
                    ->native(false)
                    ->preload()
                    ->searchable(),

                SelectFilter::make('status')
                    ->label('Status Laporan')
                    ->placeholder('Pilih Status Laporan')
                    ->options([
                        '0' => 'Menunggu Persetujuan',
                        '1' => 'Diterima',
                        '2' => 'Ditolak',
                    ])
                    ->native(false)
                    ->preload()
                    ->searchable(),

                DateRangeFilter::make('created_at')
                    ->label('Dibuat Pada')
                    ->placeholder('Pilih Rentang Tanggal'),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            ->actions([
                Action::make('approve_status')
                    ->label('Terima Laporan')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->action(fn($record) => $record->update(['status' => 1]))
                    ->visible(fn($record) => Auth::user()?->hasRole('Administrator') && $record->status === 0),

                Action::make('reportEditRequests')
                    ->label('Ajukan Perubahan')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->visible(
                        fn($record) =>
                        $record->status === 1
                        && Auth::user()?->hasRole('Kontraktor')
                        && !$record->reportEditRequests()
                            ->where('user_id', Auth::id())
                            ->whereIn('status', [0, 1])
                            ->exists()
                    )
                    ->form([
                        Textarea::make('reason')
                            ->label('Alasan Perubahan')
                            ->placeholder('Masukkan Alasan Perubahan')
                            ->minLength(10)
                            ->rows(3)
                            ->autosize()
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->action(function (array $data, Report $record) {
                        // Hapus pengajuan sebelumnya dari user untuk report yang sama
                        $record->reportEditRequests()
                            ->where('user_id', Auth::id())
                            ->delete();

                        // Simpan pengajuan perubahan baru ke tabel report_edit_requests
                        $record->reportEditRequests()->create([
                            'user_id' => Auth::id(),
                            'reason' => $data['reason'],
                            'status' => 0, // Default status pengajuan
                        ]);

                        // Ambil data user yang mengajukan perubahan
                        $userName = Auth::user()->name;

                        // Ambil semua Administrator
                        $admins = User::role('Administrator')->get();

                        // Kirim notifikasi ke user yang mengajukan perubahan
                        Notification::make()
                            ->title('Pengajuan Perubahan Dikirim')
                            ->success()
                            ->body('Pengajuan perubahan berhasil dikirim dan sedang menunggu persetujuan.')
                            ->send();

                        // Kirim notifikasi ke semua Administrator
                        Notification::make()
                            ->title('Pengajuan Perubahan Baru')
                            ->info()
                            ->body("{$userName} telah mengajukan perubahan pada laporan \"{$record->title}\" dan menunggu persetujuan.")
                            ->actions([
                                NotificationAction::make('view')
                                    ->label('Lihat Laporan')
                                    ->url('/laporan', shouldOpenInNewTab: false)
                                    ->link(),
                            ])
                            ->sendToDatabase($admins);
                    }),

                Action::make('ManageReportEditRequests')
                    ->label('Terdapat Pengajuan')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->visible(
                        fn(Report $record) =>
                        Auth::user()?->hasRole('Administrator') &&
                        $record->reportEditRequests()->where('status', 0)->exists()
                    )
                    ->modalHeading('Detail Pengajuan Perubahan')
                    ->form(function (Report $record) {
                        $editRequest = $record->reportEditRequests()->where('status', 0)->first();

                        return [
                            Group::make([
                                TextArea::make('reason')
                                    ->label('Alasan Perubahan')
                                    ->placeholder('Masukkan Alasan Perubahan')
                                    ->default($editRequest?->reason)
                                    ->rows(1)
                                    ->autosize()
                                    ->disabled(),

                                Select::make('status')
                                    ->label('Status Pengajuan')
                                    ->placeholder('Pilih Status Pengajuan')
                                    ->options([
                                        1 => 'Diterima',
                                        2 => 'Ditolak',
                                    ])
                                    ->native(false)
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ])->columns(2),
                        ];
                    })
                    ->action(function (array $data, Report $record) {
                        $editRequest = $record->reportEditRequests()->where('status', 0)->first();

                        if (!$editRequest) {
                            Notification::make()
                                ->title('Pengajuan Tidak Ditemukan')
                                ->danger()
                                ->body('Pengajuan perubahan tidak ditemukan atau sudah diproses.')
                                ->send();
                            return;
                        }

                        // Update status berdasarkan pilihan admin (1 = Setujui, 2 = Tolak)
                        $editRequest->update(['status' => $data['status']]);

                        // Ambil user yang mengajukan perubahan
                        $user = $editRequest->user;
                        $statusMessage = $data['status'] == 1 ? 'disetujui' : 'ditolak';

                        // Kirim notifikasi ke user
                        Notification::make()
                            ->title("Pengajuan Perubahan {$statusMessage}")
                            ->info()
                            ->body("Pengajuan perubahan Anda pada laporan \"{$record->title}\" telah {$statusMessage}.")
                            ->actions([
                                NotificationAction::make('view')
                                    ->label('Lihat Laporan')
                                    ->url('/laporan', shouldOpenInNewTab: false)
                                    ->link(),
                            ])
                            ->sendToDatabase([$user]);

                        // Kirim notifikasi ke admin yang memproses
                        Notification::make()
                            ->title($data['status'] == 1 ? 'Pengajuan Disetujui' : 'Pengajuan Ditolak')
                            ->success()
                            ->body($data['status'] == 1 ? 'Pengajuan perubahan telah disetujui.' : 'Pengajuan perubahan telah ditolak.')
                            ->send();
                    }),


                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
