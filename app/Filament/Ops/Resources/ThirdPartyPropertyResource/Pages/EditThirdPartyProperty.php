<?php

namespace App\Filament\Ops\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Ops\Resources\ThirdPartyPropertyResource;
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
