<?php

namespace App\Filament\Sales\Resources\FinancialControlResource\Pages;

use App\Filament\Sales\Resources\FinancialControlResource;
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
