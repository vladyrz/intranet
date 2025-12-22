<?php

namespace App\Filament\Sales\Resources\FinancialControlResource\Pages;

use App\Filament\Sales\Resources\FinancialControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialControls extends ListRecords
{
    protected static string $resource = FinancialControlResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
