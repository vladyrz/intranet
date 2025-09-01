<?php

namespace App\Filament\Sales\Resources\AdminReminderResource\Pages;

use App\Filament\Sales\Resources\AdminReminderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminReminders extends ListRecords
{
    protected static string $resource = AdminReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
