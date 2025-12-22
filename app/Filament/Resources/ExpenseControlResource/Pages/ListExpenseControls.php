<?php

namespace App\Filament\Resources\ExpenseControlResource\Pages;

use App\Filament\Resources\ExpenseControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenseControls extends ListRecords
{
    protected static string $resource = ExpenseControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
