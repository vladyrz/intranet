<?php

namespace App\Filament\Ops\Resources\FinancialControlResource\Pages;

use App\Filament\Ops\Resources\FinancialControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialControl extends EditRecord
{
    protected static string $resource = FinancialControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
