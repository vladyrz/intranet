<?php

namespace App\Filament\Soporte\Resources\OfferResource\Pages;

use App\Filament\Soporte\Resources\OfferResource;
use App\Mail\OfferStatus\OfferSent;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['offer_status'] = 'sent';

        $sentUser = User::find($data['user_id']);
        $organization = Organization::find($data['organization_id']);

        if ($sentUser && $data['offer_status'] === 'sent') {
            $dataToSend = [
                'property_name' => $data['property_name'],
                'organization' => $organization ? $organization->organization_name : 'Desconocido/a',
                'name' => $sentUser->name,
                'email' => $sentUser->email,
            ];

            Mail::to($sentUser->email)->send(new OfferSent($dataToSend));
        }

        return $data;
    }
}
