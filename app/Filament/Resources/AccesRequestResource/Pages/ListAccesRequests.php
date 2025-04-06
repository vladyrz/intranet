<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Filament\Resources\AccesRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccesRequests extends ListRecords
{
    protected static string $resource = AccesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
