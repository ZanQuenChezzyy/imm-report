<?php

namespace App\Filament\Resources\ProgressRealtimeResource\Pages;

use App\Filament\Resources\ProgressRealtimeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgressRealtime extends EditRecord
{
    protected static string $resource = ProgressRealtimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
