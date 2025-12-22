<?php

namespace App\Filament\Rrhh\Resources\FinancialControlResource\Pages;

use App\Filament\Rrhh\Resources\FinancialControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialControl extends EditRecord
{
    protected static string $resource = FinancialControlResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
