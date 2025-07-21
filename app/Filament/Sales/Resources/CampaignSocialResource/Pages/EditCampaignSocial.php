<?php

namespace App\Filament\Sales\Resources\CampaignSocialResource\Pages;

use App\Filament\Sales\Resources\CampaignSocialResource;
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
