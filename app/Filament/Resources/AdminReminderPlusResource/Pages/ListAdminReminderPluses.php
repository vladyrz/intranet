<?php

namespace App\Filament\Resources\AdminReminderPlusResource\Pages;

use App\Filament\Resources\AdminReminderPlusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminReminderPluses extends ListRecords
{
    protected static string $resource = AdminReminderPlusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
