<?php

namespace App\Filament\Resources\ReportTypeResource\Pages;

use App\Filament\Resources\ReportTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReportTypes extends ManageRecords
{
    protected static string $resource = ReportTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tipe')
                ->icon('heroicon-m-plus-circle'),
        ];
    }
}
