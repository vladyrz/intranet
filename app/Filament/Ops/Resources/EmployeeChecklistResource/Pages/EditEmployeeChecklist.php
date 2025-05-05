<?php

namespace App\Filament\Ops\Resources\EmployeeChecklistResource\Pages;

use App\Filament\Ops\Resources\EmployeeChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeChecklist extends EditRecord
{
    protected static string $resource = EmployeeChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
