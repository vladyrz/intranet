<?php

namespace App\Filament\Ops\Resources\BillingControlResource\Pages;

use App\Filament\Ops\Resources\BillingControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBillingControls extends ListRecords
{
    protected static string $resource = BillingControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
