<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('EditProfile')
                    ->tabs([
                        Tab::make('Informasi Pribadi')
                            ->schema([
                                FileUpload::make('avatar_url')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                    ])
                                    ->imageCropAspectRatio('1:1')
                                    ->directory('avatar_upload')
                                    ->visibility('public')
                                    ->helperText('Format yang didukung: JPG, PNG, atau GIF.')
                                    ->columnSpanFull(),

                                TextInput::make('name')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.name.label'))
                                    ->placeholder(__('Masukkan Nama'))
                                    ->inlineLabel()
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),

                                TextInput::make('email')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
                                    ->placeholder(__('Masukkan Email'))
                                    ->inlineLabel()
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                TextInput::make('npwp')
                                    ->label('Nomor NPWP')
                                    ->placeholder('Masukkan nomor NPWP')
                                    ->inlineLabel()
                                    ->minLength(12)
                                    ->maxLength(21)
                                    ->unique(ignoreRecord: true),

                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->placeholder('Masukkan Nomor Telepon')
                                    ->inlineLabel()
                                    ->prefix('+62')
                                    ->minValue(1)
                                    ->minLength(10)
                                    ->maxLength(15)
                                    ->tel()
                                    ->mask(
                                        RawJs::make(<<<'JS'
                                $input.startsWith('+62')
                                    ? $input.replace(/^\+62/, '')
                                    : ($input.startsWith('62')
                                        ? $input.replace(/^62/, '')
                                        : ($input.startsWith('0')
                                    ? $input.replace(/^0/, '')
                                    : $input
                                    )
                                )
                            JS)
                                    )
                                    ->stripCharacters([' ', '-', '(', ')'])
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $cleaned = preg_replace('/^(\+62|62|0)/', '', $state);
                                        if (!str_starts_with($cleaned, '8')) {
                                            $set('no_hp', null);
                                        } else {
                                            $set('no_hp', $cleaned);
                                        }
                                    })
                                    ->Unique(ignoreRecord: true),
                            ]),
                        Tab::make('Kontrak')
                            ->schema([
                                Select::make('contracts')
                                    ->label('Kontrak Kerja')
                                    ->placeholder('Pilih atau Tambahkan Kontrak Kerja')
                                    ->relationship(
                                        'contracts',
                                        'name',
                                        fn($query, $get) => $query
                                            ->where('user_id', $get('id')) // Hanya kontrak milik user yang sedang diedit
                                            ->whereDate('period_end', '>=', now()) // Hanya kontrak yang masih aktif
                                    )
                                    ->default(
                                        fn($get) => \App\Models\Contract::where('user_id', $get('id'))
                                            ->where('status', 1) // Hanya kontrak yang statusnya aktif
                                            ->orderByDesc('period_start') // Ambil kontrak terbaru
                                            ->value('id') // Ambil ID sebagai default
                                    )
                                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} - (" . ($record->status ? 'Aktif' : 'Tidak Aktif') . ")")
                                    ->native(false)
                                    ->createOptionForm([
                                        Group::make([
                                            Select::make('user_id')
                                                ->label('Nama Pengguna')
                                                ->relationship('user', 'name')
                                                ->native(false)
                                                ->preload()
                                                ->searchable()
                                                ->default(Auth::user()->id)
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
                                        ])->columns(2)
                                    ])
                                    ->editOptionForm([
                                        Group::make([
                                            Select::make('user_id')
                                                ->label('Nama Pengguna')
                                                ->relationship('user', 'name')
                                                ->native(false)
                                                ->preload()
                                                ->searchable()
                                                ->default(Auth::user()->id)
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
                                        ])->columns(2)
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Kata Sandi')
                            ->schema([
                                TextInput::make('password')
                                    ->label(__('Kata Sandi'))
                                    ->placeholder(__('Kosongkan jika tidak ingin mengubah'))
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->rule(Password::default())
                                    ->autocomplete('new-password')
                                    ->dehydrated(fn($state): bool => filled($state))
                                    ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                                    ->live(debounce: 500)
                                    ->same('passwordConfirmation'),

                                TextInput::make('passwordConfirmation')
                                    ->label(__('Konfirmasi Kata Sandi'))
                                    ->placeholder(__('Masukkan lagi Kata sandi'))
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->required()
                                    ->visible(fn(Get $get): bool => filled($get('password')))
                                    ->dehydrated(false),
                            ]),


                    ]),
            ]);
    }
}
