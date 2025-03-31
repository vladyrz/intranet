<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use App\Mail\OfferStatus\OfferApproved;
use App\Mail\OfferStatus\OfferRejected;
use App\Mail\OfferStatus\OfferSent;
use App\Mail\OfferStatus\OfferSigned;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        //Send Email only if Approved
        if ($record->offer_status == 'approved') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_name' => $record->property_name
            );
            Mail::to($user)->send(new OfferApproved($data));
        }

        // Send Email only if Rejected

        else if ($record->offer_status == 'rejected') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_name' => $record->property_name
            );
            Mail::to($user)->send(new OfferRejected($data));
        }

        // Send Email only if Sent

        else if ($record->offer_status == 'sent') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_name' => $record->property_name
            );
            Mail::to($user)->send(new OfferSent($data));
        }

        // Send Email only if Signed

        else if ($record->offer_status == 'signed') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_name' => $record->property_name
            );
            Mail::to($user)->send(new OfferSigned($data));
        }

        return $record;
    }
}
