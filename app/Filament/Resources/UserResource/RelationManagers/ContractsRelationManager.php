<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'contract';

    public function form(Form $form): Form
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

                FileUpload::make('file')
                    ->label('Lampiran (Jika Ada)')
                    ->columnSpanFull()
                    ->nullable(),

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

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Kontrak Kerja')
            ->modifyQueryUsing(fn($query) => $query->orderBy('period_start', 'desc')->orderBy('period_end', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Nomor'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kontrak'),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan'),
                Tables\Columns\TextColumn::make('period_start')
                    ->date()
                    ->label('Tanggal Mulai'),
                Tables\Columns\TextColumn::make('period_end')
                    ->date()
                    ->label('Tanggal Selesai'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ((string) $state) {
                        '0' => 'gray',
                        '1' => 'success',
                        default => 'Tidak Diketahui',
                    })
                    ->formatStateUsing(fn(string $state): string => match ((string) $state) {
                        '0' => 'Selesai',
                        '1' => 'Aktif',
                        default => 'Tidak Diketahui',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        '0' => 'heroicon-s-document-minus',
                        '1' => 'heroicon-s-clipboard-document-check',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Kontrak')
                    ->createAnother(false),
            ])
            ->actions([
                ActionGroup::make([
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
}
