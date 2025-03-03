<?php

namespace App\Filament\Personal\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Personal\Resources\PropertyAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyAssignments extends ListRecords
{
    protected static string $resource = PropertyAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
