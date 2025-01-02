<?php

namespace App\Filament\Ops\Resources\EmployeeResource\Pages;

use App\Filament\Ops\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
