<?php

namespace App\Filament\Personal\Resources\CreditStudyRequestResource\Pages;

use App\Filament\Personal\Resources\CreditStudyRequestResource;
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
