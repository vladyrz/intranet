<?php

namespace App\Filament\Ops\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Ops\Resources\ThirdPartyPropertyResource;
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
