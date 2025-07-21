<?php

namespace App\Filament\Rrhh\Resources\CampaignSocialResource\Pages;

use App\Filament\Rrhh\Resources\CampaignSocialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaignSocial extends EditRecord
{
    protected static string $resource = CampaignSocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
