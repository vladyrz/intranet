<?php

namespace App\Filament\Sales\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Sales\Resources\PropertyAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyAssignment extends EditRecord
{
    protected static string $resource = PropertyAssignmentResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
