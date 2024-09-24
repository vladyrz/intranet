<?php

namespace App\Filament\Resources\KeyRequestResource\Pages;

use App\Filament\Resources\KeyRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeyRequest extends EditRecord
{
    protected static string $resource = KeyRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
