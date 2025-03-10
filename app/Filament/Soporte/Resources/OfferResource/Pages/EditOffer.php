<?php

namespace App\Filament\Soporte\Resources\OfferResource\Pages;

use App\Filament\Soporte\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
