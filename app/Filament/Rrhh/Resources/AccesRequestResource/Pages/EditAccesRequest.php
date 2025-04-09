<?php

namespace App\Filament\Rrhh\Resources\AccesRequestResource\Pages;

use App\Filament\Rrhh\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesApproved;
use App\Mail\RequestStatus\AccesRejected;
use App\Mail\RequestStatus\AccesSent;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EditAccesRequest extends EditRecord
{
    protected static string $resource = AccesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        //send email only if the request status is sent
        if ($record->request_status == 'sent') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property' => $record->property,
            );
            Mail::to($user)->send(new AccesSent($data));
        }

        //send email only if the request status is approved
        if ($record->request_status == 'approved') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property' => $record->property,
            );
            Mail::to($user)->send(new AccesApproved($data));
        }

        //send email only if the request status is rejected
        if ($record->request_status == 'rejected') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property' => $record->property,
            );
            Mail::to($user)->send(new AccesRejected($data));
        }

        return $record;
    }
}
