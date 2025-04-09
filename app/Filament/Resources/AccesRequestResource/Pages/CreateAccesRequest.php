<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Filament\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesSent;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateAccesRequest extends CreateRecord
{
    protected static string $resource = AccesRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['request_status'] = 'sent';

        $sentUser = User::find($data['user_id']);

        if ($sentUser && $data['request_status'] === 'sent') {
            $dataToSend = [
                'property' => $data['property'],'Desconodido/a',
                'name' => $sentUser->name,
                'email' => $sentUser->email,
            ];

            Mail::to($sentUser->email)->send(new AccesSent($dataToSend));
        }

        return $data;
    }
}
