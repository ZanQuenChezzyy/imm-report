<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static ?string $label = 'Laporan';
    protected static ?string $navigationGroup = 'Laporan & Progres';
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
                    ->default(Auth::user()->id)
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->hidden(Auth::user()->hasRole('User'))
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->placeholder('Masukkan Judul Laporan')
                    ->minLength(10)
                    ->maxLength(45)
                    ->columnSpan(Auth::user()->hasRole('User') ? 1 : 2)
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi laporan')
                    ->placeholder('Masukkan Deskripsi Laporan')
                    ->minLength(10)
                    ->rows(3),

                Group::make([
                    Forms\Components\FileUpload::make('file_path')
                        ->required(),

                    Forms\Components\Select::make('status')
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
                        ->default(0)
                        ->required(),

                    Forms\Components\TextInput::make('file_name')
                        ->required()
                        ->hidden()
                        ->maxLength(100),
                ]),


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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
