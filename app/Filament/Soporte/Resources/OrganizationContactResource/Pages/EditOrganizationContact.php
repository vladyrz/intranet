<?php

namespace App\Filament\Soporte\Resources\OrganizationContactResource\Pages;

use App\Filament\Soporte\Resources\OrganizationContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationContact extends EditRecord
{
    protected static string $resource = OrganizationContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
