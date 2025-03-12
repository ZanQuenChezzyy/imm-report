<?php

namespace App\Filament\Pages;

use App\Models\Contract;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Facades\Auth;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = '/';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $activeNavigationIcon = 'heroicon-s-home';
    protected static ?int $navigationSort = -2;

    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Select::make('tahun')
                        ->label('Filter Tahun')
                        ->options($this->getTahunOptions())
                        ->searchable()
                        ->native(false)
                        ->default(date('Y'))
                        ->reactive(),
                ])->hidden(Auth::user()->hasRole('Kontraktor'))
        ]);
    }

    protected function getTahunOptions(): array
    {
        return Contract::selectRaw('YEAR(period_end) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun', 'tahun')
            ->toArray();
    }
}
