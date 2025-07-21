<?php

namespace App\Filament\Ops\Resources\CampaignSocialResource\Pages;

use App\Filament\Ops\Resources\CampaignSocialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampaignSocials extends ListRecords
{
    protected static string $resource = CampaignSocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
