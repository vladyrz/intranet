<?php

namespace App\Filament\Rrhh\Resources\PersonalCustomerResource\Pages;

use App\Filament\Rrhh\Resources\PersonalCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalCustomer extends EditRecord
{
    protected static string $resource = PersonalCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
