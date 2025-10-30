<?php

namespace App\Filament\Services\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Services\Resources\ThirdPartyPropertyResource;
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
