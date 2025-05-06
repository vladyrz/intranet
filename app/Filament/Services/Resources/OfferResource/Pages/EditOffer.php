<?php

namespace App\Filament\Services\Resources\OfferResource\Pages;

use App\Filament\Services\Resources\OfferResource;
use App\Mail\OfferStatus\OfferApproved;
use App\Mail\OfferStatus\OfferRejected;
use App\Mail\OfferStatus\OfferSent;
use App\Mail\OfferStatus\OfferSigned;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        $user = User::find($record->user_id);

        if (!$user) {
            return; // Evitar errores si no se encuentra el usuario
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'property_name' => $record->property_name,
        ];

        switch ($record->offer_status) {
            case 'approved':
                Mail::to($user->email)->send(new OfferApproved($data));
                break;

            case 'rejected':
                Mail::to($user->email)->send(new OfferRejected($data));
                break;

            case 'sent':
                Mail::to($user->email)->send(new OfferSent($data));
                break;

            case 'signed':
                Mail::to($user->email)->send(new OfferSigned($data));
                break;
        }
    }
}
