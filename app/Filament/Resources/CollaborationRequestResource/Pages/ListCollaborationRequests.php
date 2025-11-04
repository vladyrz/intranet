<?php

namespace App\Filament\Resources\CollaborationRequestResource\Pages;

use App\Filament\Resources\CollaborationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollaborationRequests extends ListRecords
{
    protected static string $resource = CollaborationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
