<?php

namespace App\Filament\Rrhh\Resources\EmployeeResource\Pages;

use App\Filament\Rrhh\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
