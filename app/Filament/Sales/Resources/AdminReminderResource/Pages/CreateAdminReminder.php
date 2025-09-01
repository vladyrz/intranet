<?php

namespace App\Filament\Sales\Resources\AdminReminderResource\Pages;

use App\Filament\Sales\Resources\AdminReminderResource;
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
