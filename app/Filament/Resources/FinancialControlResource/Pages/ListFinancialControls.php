<?php

namespace App\Filament\Resources\FinancialControlResource\Pages;

use App\Filament\Resources\FinancialControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialControls extends ListRecords
{
    protected static string $resource = FinancialControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
