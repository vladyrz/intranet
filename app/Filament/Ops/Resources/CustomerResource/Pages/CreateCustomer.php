<?php

namespace App\Filament\Ops\Resources\CustomerResource\Pages;

use App\Filament\Ops\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
