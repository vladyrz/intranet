<?php

namespace App\Filament\Personal\Resources\ThirdPartyPropertyResource\Pages;

use App\Filament\Personal\Resources\ThirdPartyPropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateThirdPartyProperty extends CreateRecord
{
    protected static string $resource = ThirdPartyPropertyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
}
