<?php

namespace App\Filament\Resources\PersonalCustomerResource\Pages;

use App\Filament\Resources\PersonalCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonalCustomers extends ListRecords
{
    protected static string $resource = PersonalCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
