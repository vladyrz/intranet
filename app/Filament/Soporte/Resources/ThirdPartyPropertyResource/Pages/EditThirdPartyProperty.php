<?php

namespace App\Filament\Soporte\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Soporte\Resources\ThirdPartyPropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThirdPartyProperty extends EditRecord
{
    protected static string $resource = ThirdPartyPropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
