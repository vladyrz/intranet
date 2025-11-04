<?php

namespace App\Filament\Ops\Resources\CollaborationRequestResource\Pages;

use App\Filament\Ops\Resources\CollaborationRequestResource;
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
