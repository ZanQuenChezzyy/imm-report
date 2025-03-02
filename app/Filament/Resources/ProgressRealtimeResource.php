<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgressRealtimeResource\Pages;
use App\Filament\Resources\ProgressRealtimeResource\RelationManagers;
use App\Models\ProgressRealtime;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProgressRealtimeResource extends Resource
{
    protected static ?string $model = ProgressRealtime::class;
    protected static ?string $label = 'Progres';
    protected static ?string $navigationGroup = 'Laporan & Progres';
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $activeNavigationIcon = 'heroicon-s-document-chart-bar';
    protected static ?int $navigationSort = 5;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Progres';
    protected static ?string $slug = 'progres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Progres')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Proyek')
                            ->placeholder('Pilih Proyek')
                            ->relationship('project', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('user_id')
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

                        Forms\Components\TextInput::make('progress')
                            ->label('Progres (%)')
                            ->placeholder('Masukkan Progres (%)')
                            ->minValue(0)
                            ->maxValue(100)
                            ->minLength(3)
                            ->prefix('Progress')
                            ->suffix('%')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan Deskripsi')
                            ->rows(4)
                            ->autosize()
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProgressRealtimes::route('/'),
            'create' => Pages\CreateProgressRealtime::route('/create'),
            'view' => Pages\ViewProgressRealtime::route('/{record}'),
            'edit' => Pages\EditProgressRealtime::route('/{record}/edit'),
        ];
    }
}
