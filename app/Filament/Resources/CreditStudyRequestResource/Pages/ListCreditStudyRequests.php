<?php

namespace App\Filament\Resources\CreditStudyRequestResource\Pages;

use App\Filament\Resources\CreditStudyRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditStudyRequests extends ListRecords
{
    protected static string $resource = CreditStudyRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
