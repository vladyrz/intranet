<?php

namespace App\Filament\Ops\Resources\BillingControlResource\Pages;

use App\Filament\Ops\Resources\BillingControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBillingControl extends EditRecord
{
    protected static string $resource = BillingControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
