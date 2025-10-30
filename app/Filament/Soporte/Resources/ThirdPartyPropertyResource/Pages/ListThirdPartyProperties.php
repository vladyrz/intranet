<?php

namespace App\Filament\Soporte\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Soporte\Resources\ThirdPartyPropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThirdPartyProperties extends ListRecords
{
    protected static string $resource = ThirdPartyPropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
