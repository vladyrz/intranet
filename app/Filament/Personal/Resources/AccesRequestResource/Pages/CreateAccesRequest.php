<?php

namespace App\Filament\Personal\Resources\AccesRequestResource\Pages;

use App\Filament\Personal\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesPending;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateAccesRequest extends CreateRecord
{
    protected static string $resource = AccesRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        $userRol = User::role('soporte')->get('email');

        $dataToSend = array(
            'type_of_request' => __('translate.access_request.options_type_of_request.' . $data['type_of_request']),
            'property' => $data['property'],
            'organization' => Organization::find($data['organization_id'])->organization_name,
            'email' => User::find($data['user_id'])->email,
        );

        foreach ($userRol as $user) {
            Mail::to($user)->send(new AccesPending($dataToSend));
        }

        return $data;
    }
}
