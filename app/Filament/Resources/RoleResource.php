<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\RolePermission;
use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $cluster = RolePermission::class;
    protected static ?string $label = 'Peran Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $activeNavigationIcon = 'heroicon-s-identification';
    protected static ?int $navigationSort = 18;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Peran Pengguna';
    protected static ?string $slug = 'peran';

    public static function form(Form $form): Form
    {
        // Group permissions berdasarkan resource
        $groupedPermissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return ucfirst(end($parts));
        });

        return $form
            ->schema([
                Section::make(__('permission.role_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('permission.Role Name'))
                            ->placeholder(__('permission.Enter Role Name'))
                            ->minLength(3)
                            ->maxLength(45)
                            ->unique(ignoreRecord: true)
                            ->required(),

                        Toggle::make('select_all')
                            ->label(__('permission.select_all'))
                            ->helperText(__('permission.enable_role'))
                            ->dehydrated(false)
                            ->onIcon('heroicon-m-shield-check')
                            ->offIcon('heroicon-m-shield-exclamation')
                            ->live()
                            ->afterStateHydrated(function ($set, $record) use ($groupedPermissions) {
                                $allPermissionIds = $groupedPermissions->flatten()->pluck('id')->toArray();
                                $selectedPermissions = $record?->permissions->pluck('id')->toArray() ?? [];
                                $isAllSelected = count($selectedPermissions) === count($allPermissionIds);
                                $set('select_all', $isAllSelected);
                            })
                            ->afterStateUpdated(function ($state, callable $set, $get) use ($groupedPermissions) {
                                $allPermissionIds = $groupedPermissions->flatten()->pluck('id')->toArray();
                                if ($state) {
                                    $set('permissions', $allPermissionIds);
                                } else {
                                    $set('permissions', []);
                                }
                            }),
                    ])->columns(2),

                Tabs::make(__('permission.Permission'))
                    ->tabs([
                        Tab::make(__('permission.Permission'))
                            ->schema(
                                $groupedPermissions->map(function ($permissions, $resource) use ($groupedPermissions) {
                                    return Section::make("{$resource}")
                                        ->description("App\\Models\\{$resource}")
                                        ->schema([
                                            CheckboxList::make('permissions')
                                                ->label("")
                                                ->bulkToggleable()
                                                ->columns(3)
                                                ->relationship('permissions', 'name')
                                                ->options(
                                                    $permissions->mapWithKeys(function ($permission) {
                                                        $parts = explode(' ', $permission->name);
                                                        array_pop($parts);
                                                        $action = implode(' ', $parts);
                                                        $translatedAction = __('permission.' . $action);
                                                        return [$permission->id => $translatedAction];
                                                    })
                                                )
                                                ->live() // Aktifkan live update
                                                ->afterStateUpdated(function ($state, callable $set, $get) use ($groupedPermissions) {
                                                    $allPermissionIds = $groupedPermissions->flatten()->pluck('id')->toArray();
                                                    $isAllSelected = count($state) === count($allPermissionIds);
                                                    $set('select_all', $isAllSelected);
                                                }),
                                        ])->columnSpan(1)
                                        ->collapsible();
                                })->values()->toArray()
                            )->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Peran')
                    ->searchable(),

                TextColumn::make('permissions.name')
                    ->label('Perizinan')
                    ->colors([
                        'info',
                    ])
                    ->badge()
                    ->separator(', ')
                    ->limitList(4)
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
