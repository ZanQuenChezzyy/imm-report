<?php

namespace App\Filament\Resources\ProgressRealtimeResource\Pages;

use App\Filament\Resources\ProgressRealtimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgressRealtimes extends ListRecords
{
    protected static string $resource = ProgressRealtimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
