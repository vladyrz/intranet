<?php

namespace App\Filament\Rrhh\Resources\CustomerReportResource\Pages;

use App\Filament\Rrhh\Resources\CustomerReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerReport extends EditRecord
{
    protected static string $resource = CustomerReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
