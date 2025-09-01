<?php

namespace App\Filament\Sales\Resources\AdminReminderResource\Pages;

use App\Filament\Sales\Resources\AdminReminderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminReminder extends EditRecord
{
    protected static string $resource = AdminReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
