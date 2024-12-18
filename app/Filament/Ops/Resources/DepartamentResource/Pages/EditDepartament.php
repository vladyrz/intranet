<?php

namespace App\Filament\Ops\Resources\DepartamentResource\Pages;

use App\Filament\Ops\Resources\DepartamentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartament extends EditRecord
{
    protected static string $resource = DepartamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
