<?php

namespace App\Filament\Rrhh\Resources\CreditStudyRequestResource\Pages;

use App\Filament\Rrhh\Resources\CreditStudyRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditStudyRequest extends EditRecord
{
    protected static string $resource = CreditStudyRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
