<?php

namespace App\Filament\Personal\Resources\OfferResource\Pages;

use App\Filament\Personal\Resources\OfferResource;
use App\Mail\OfferStatus\OfferPending;
use App\Models\Organization;
use App\Models\PersonalCustomer;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $userRol = User::role('soporte')->get('email');

        $amount = $this->record->offer_amount_usd
            ? '$' . number_format($this->record->offer_amount_usd, 2)
            : '₡' . number_format($this->record->offer_amount_crc, 2);

        $attachments = [];
        if (!empty($this->record->offer_files)) {
            foreach ($this->record->offer_files as $filePath) {
                $attachments[] = Storage::disk('public')->path($filePath);
            }
        }

        $dataToSend = [
            'property_name' => $this->record->property_name,
            'organization' => Organization::find($this->record->organization_id)?->organization_name,
            'email' => $this->record->user->email,
            'customer_name' => PersonalCustomer::find($this->record->personal_customer_id)?->full_name,
            'customer_national_id' => PersonalCustomer::find($this->record->personal_customer_id)?->national_id,
            'offer_amount' => $amount,
            'attachments' => $attachments,
        ];

        foreach ($userRol as $user) {
            Mail::to($user->email)->send(new OfferPending($dataToSend));
        }
    }
}
