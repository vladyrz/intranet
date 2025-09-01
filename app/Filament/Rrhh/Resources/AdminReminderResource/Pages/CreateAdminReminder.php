<?php

namespace App\Filament\Rrhh\Resources\AdminReminderResource\Pages;

use App\Filament\Rrhh\Resources\AdminReminderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAdminReminder extends CreateRecord
{
    protected static string $resource = AdminReminderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
