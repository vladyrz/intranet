<?php

namespace App\Filament\Sales\Resources\OfferResource\Pages;

use App\Filament\Sales\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
