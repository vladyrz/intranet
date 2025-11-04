<?php

namespace App\Filament\Services\Resources\CollaborationRequestResource\Pages;

use App\Filament\Services\Resources\CollaborationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollaborationRequest extends EditRecord
{
    protected static string $resource = CollaborationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
