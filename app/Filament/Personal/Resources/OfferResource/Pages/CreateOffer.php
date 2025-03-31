<?php

namespace App\Filament\Personal\Resources\OfferResource\Pages;

use App\Filament\Personal\Resources\OfferResource;
use App\Mail\OfferStatus\OfferPending;
use App\Models\Organization;
use App\Models\PersonalCustomer;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        $userRol = User::role('soporte')->get('email');

        $amount = $data['offer_amount_usd']
        ? '$' . number_format($data['offer_amount_usd'], 2)
        : '₡' . number_format($data['offer_amount_crc'], 2);

        $attachments = [];
        if (!empty($data['offer_files'])) {
            foreach ($data['offer_files'] as $filePath) {
                $attachments[] = Storage::disk('public')->path($filePath);
            }
        }

        $dataToSend = array (
            'property_name' => $data['property_name'],
            'organization' => Organization::find($data['organization_id'])->organization_name,
            'email' => User::find($data['user_id'])->email,
            'customer_name' => PersonalCustomer::find($data['personal_customer_id'])->full_name,
            'customer_national_id' => PersonalCustomer::find($data['personal_customer_id'])->national_id,
            'offer_amount' => $amount,
            'attachments' => $attachments,
        );

        foreach ($userRol as $user) {
            Mail::to($user)->send(new OfferPending($dataToSend));
        }

        return $data;
    }
}
