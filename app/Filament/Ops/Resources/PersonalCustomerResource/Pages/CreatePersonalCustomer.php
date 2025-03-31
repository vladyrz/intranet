<?php

namespace App\Filament\Ops\Resources\PersonalCustomerResource\Pages;

use App\Filament\Ops\Resources\PersonalCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonalCustomer extends CreateRecord
{
    protected static string $resource = PersonalCustomerResource::class;
}
