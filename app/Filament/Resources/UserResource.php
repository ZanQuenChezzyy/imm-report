<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $label = 'Pengguna';
    protected static ?string $navigationGroup = 'Kelola Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';
    protected static ?int $navigationSort = 20;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Pengguna';
    protected static ?string $slug = 'pengguna';

    public static function getUserId(Get $get, Set $set)
    {

    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
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
                            ]),
                        Section::make()
                            ->schema([
                                Select::make('roles')
                                    ->label('Peran Pengguna')
                                    ->placeholder('Pilih Peran Pengguna')
                                    ->relationship('roles', 'name')
                                    ->native(false)
                                    ->preload()
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->required(),

                                Select::make('companies')
                                    ->label('Perusahaan Pengguna')
                                    ->placeholder('Pilih Perusahaan Pengguna')
                                    ->relationship('companies', 'name')
                                    ->native(false)
                                    ->preload()
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 3,
                        'sm' => 3,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 1,
                        '2xl' => 1,
                    ])
                    ->columns(1),

                Section::make('Informasi Pribadi')
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
                            ->native(false)
                            ->createOptionForm([
                                Group::make([
                                    Select::make('user_id')
                                        ->label('Nama Pengguna')
                                        ->relationship('user', 'name')
                                        ->native(false)
                                        ->preload()
                                        ->searchable()
                                        ->default(fn($livewire) => $livewire->record?->id)
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

                        TextInput::make('name')
                            ->label(__('filament-panels::pages/auth/edit-profile.form.name.label'))
                            ->placeholder(__('filament-panels::pages/auth/edit-profile.form.name.placeholder'))
                            ->required()
                            ->minLength(3)
                            ->maxLength(45)
                            ->autofocus(),

                        TextInput::make('email')
                            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
                            ->placeholder(__('filament-panels::pages/auth/edit-profile.form.email.placeholder'))
                            ->email()
                            ->required()
                            ->minLength(3)
                            ->maxLength(45)
                            ->unique(ignoreRecord: true),

                        TextInput::make('npwp')
                            ->label('Nomor NPWP')
                            ->placeholder('Masukkan nomor NPWP')
                            ->minLength(12)
                            ->maxLength(21)
                            ->unique(ignoreRecord: true),

                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('Masukkan Nomor Telepon')
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

                        TextInput::make('password')
                            ->label(function ($record) {
                                return $record ? 'Ubah Kata Sandi' : 'Kata Sandi';
                            })
                            ->placeholder(function ($record) {
                                return $record ? 'Kata Sandi' : 'Masukkan Kata Sandi';
                            })
                            ->password()
                            ->helperText('Kosongkan jika tidak ingin mengubah Kata sandi')
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrated(fn($state): bool => filled($state))
                            ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation')
                            ->required(fn($record) => is_null($record)),

                        TextInput::make('passwordConfirmation')
                            ->label(__('Konfirmasi Kata Sandi'))
                            ->placeholder(__('Masukkan lagi Kata sandi'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->visible(fn(Get $get): bool => filled($get('password')))
                            ->dehydrated(false),
                    ])->columnSpan([
                            'default' => fn(?User $record) => $record === null ? 3 : 3,
                            'sm' => fn(?User $record) => $record === null ? 2 : 3,
                            'md' => fn(?User $record) => $record === null ? 3 : 3,
                            'lg' => fn(?User $record) => $record === null ? 4 : 4,
                            'xl' => fn(?User $record) => $record === null ? 3 : 2,
                            '2xl' => fn(?User $record) => $record === null ? 3 : 2,
                        ])
                    ->columns(2),

                Group::make([
                    Section::make()
                        ->schema([
                            Placeholder::make('created_at')
                                ->label('Dibuat Saat')
                                ->content(fn(User $record): ?string => $record->created_at?->diffForHumans()),

                            Placeholder::make('updated_at')
                                ->label('Terakhir Diperbarui')
                                ->content(fn(User $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan([
                            'default' => 3,
                            'sm' => 3,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 1,
                            '2xl' => 1,
                        ])
                        ->hidden(fn(?User $record) => $record === null),
                    Section::make()
                        ->schema([
                            Select::make('status')
                                ->label('Status Pengguna')
                                ->placeholder('Pilih Status Pengguna')
                                ->options([
                                    true => 'Aktif',
                                    false => 'Non aktif',
                                ])
                                ->native(false)
                                ->preload()
                                ->searchable(),
                        ])
                        ->columnSpan([
                            'default' => 3,
                            'sm' => 3,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 1,
                            '2xl' => 1,
                        ])
                        ->hidden(fn(?User $record) => $record === null),
                ])

            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Pengguna')
                    ->formatStateUsing(function (User $record) {
                        $nameParts = explode(' ', trim($record->name));
                        $initials = isset($nameParts[1])
                            ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                            : strtoupper(substr($nameParts[0], 0, 1));
                        $avatarUrl = $record->avatar_url
                            ? asset('storage/' . $record->avatar_url)
                            : 'https://ui-avatars.com/api/?name=' . $initials . '&amp;color=FFFFFF&amp;background=030712';
                        $image = '<img class="w-10 h-10 rounded-lg" style="margin-right: 0.625rem !important;" src="' . $avatarUrl . '" alt="Avatar User">';
                        $nama = '<strong class="text-sm font-medium text-gray-800">' . e($record->name) . '</strong>';
                        $email = '<span class="font-light text-gray-300">' . e($record->email) . '</span>';
                        return '<div class="flex items-center" style="margin-right: 4rem !important">'
                            . $image
                            . '<div>' . $nama . '<br>' . $email . '</div></div>';
                    })
                    ->html()
                    ->searchable(['name', 'email']),

                TextColumn::make('roles.name')
                    ->label('Peran Pengguna')
                    ->colors([
                        'info',
                    ])
                    ->badge()
                    ->separator(', ')
                    ->limitList(3)
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->color('info'),
                    DeleteAction::make()
                        ->authorize(function ($record) {
                            return Auth::id() !== $record->id;
                        })
                        ->using(function ($record) {
                            if ($record->id === Auth::id()) {
                                session()->flash('error', 'You cannot delete your own account.');
                                return false;
                            }
                            $record->delete();
                        })
                        ->requiresConfirmation(),
                ])
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->color('info')
                    ->tooltip('Aksi')
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->using(function ($records) {
                            $recordsToDelete = $records->reject(function ($record) {
                                return $record->id === Auth::id();
                            });
                            $recordsToDelete->each(function ($record) {
                                $record->delete();
                            });
                            session()->flash('message', 'Selected accounts were deleted, except for your own account.');
                        })
                        ->requiresConfirmation(),
                    ExportBulkAction::make()
                        ->exporter(UserExporter::class)
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContractsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
