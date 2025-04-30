<?php

namespace App\Filament\Personal\Resources\CustomerReportResource\Pages;

use App\Filament\Personal\Resources\CustomerReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerReport extends EditRecord
{
    protected static string $resource = CustomerReportResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
