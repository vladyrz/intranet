<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Filament\Resources\AccesRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccesRequest extends EditRecord
{
    protected static string $resource = AccesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
