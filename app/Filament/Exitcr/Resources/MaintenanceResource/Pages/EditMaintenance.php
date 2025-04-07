<?php

namespace App\Filament\Exitcr\Resources\MaintenanceResource\Pages;

use App\Filament\Exitcr\Resources\MaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenance extends EditRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
