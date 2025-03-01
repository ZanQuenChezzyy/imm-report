<?php

namespace App\Filament\Resources\ProgressRealtimeResource\Pages;

use App\Filament\Resources\ProgressRealtimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProgressRealtime extends ViewRecord
{
    protected static string $resource = ProgressRealtimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
