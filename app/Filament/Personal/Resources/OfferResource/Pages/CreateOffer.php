<?php

namespace App\Filament\Personal\Resources\OfferResource\Pages;

use App\Filament\Personal\Resources\OfferResource;
use App\Mail\OfferStatus\OfferPending;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $userRol = User::role('soporte')->get('email');
        $dataToSend = array (
            'property_name' => $data['property_name'],
            'organization' => Organization::find($data['organization_id'])->organization_name,
            'name' => User::find($data['user_id'])->name,
            'email' => User::find($data['user_id'])->email,
        );

        foreach ($userRol as $user) {
            Mail::to($user)->send(new OfferPending($dataToSend));
        }

        return $data;
    }
}
