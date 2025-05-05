<?php

namespace App\Filament\Rrhh\Resources\EmployeeChecklistResource\Pages;

use App\Filament\Rrhh\Resources\EmployeeChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeChecklists extends ListRecords
{
    protected static string $resource = EmployeeChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
