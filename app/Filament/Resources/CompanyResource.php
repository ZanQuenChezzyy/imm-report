<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $label = 'Perusahaan';
    protected static ?string $navigationGroup = 'Kelola Data';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $activeNavigationIcon = 'heroicon-s-building-office-2';
    protected static ?int $navigationSort = 2;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }
    protected static ?string $navigationBadgeTooltip = 'Total Perusahaan';
    protected static ?string $slug = 'perusahaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Perusahaan')
                    ->placeholder('Masukkan Nama Perusahaan')
                    ->inlineLabel()
                    ->helperText(new HtmlString(
                        'Nama perusahaan harus <strong>unik</strong> dan tidak boleh sama dengan perusahaan lain. <br>
                        • Minimal <strong>3 karakter</strong> dan maksimal <strong>45 karakter</strong>. <br>
                        • Hanya boleh mengandung <strong>huruf, angka, spasi, dan titik</strong>. <br>
                        • Tidak boleh menggunakan <strong>simbol</strong> atau <strong>karakter khusus</strong>. <br>
                        Contoh: <br>
                        <strong>PT. Indominco Mandiri</strong>'
                    ))
                    ->minLength(3)
                    ->maxLength(45)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }
}
