<?php

namespace App\Filament\Ops\Resources\OperationResource\Pages;

use App\Filament\Ops\Resources\OperationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperations extends ListRecords
{
    protected static string $resource = OperationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
