<?php

namespace App\Filament\Personal\Resources\PersonalCustomerResource\Pages;

use App\Filament\Personal\Resources\PersonalCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePersonalCustomer extends CreateRecord
{
    protected static string $resource = PersonalCustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }
}
