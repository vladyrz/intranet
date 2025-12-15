<?php

namespace App\Filament\Resources\AdminReminderPlusResource\Pages;

use App\Filament\Resources\AdminReminderPlusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminReminderPlus extends EditRecord
{
    protected static string $resource = AdminReminderPlusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
