<?php

namespace App\Filament\Personal\Resources\AdRequestResource\Pages;

use App\Filament\Personal\Resources\AdRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdRequest extends EditRecord
{
    protected static string $resource = AdRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
