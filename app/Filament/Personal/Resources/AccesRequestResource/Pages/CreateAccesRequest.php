<?php

namespace App\Filament\Personal\Resources\AccesRequestResource\Pages;

use App\Filament\Personal\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesPending;
use App\Models\Organization;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;

class CreateAccesRequest extends CreateRecord
{
    protected static string $resource = AccesRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        $organization = Organization::find($record->organization_id);
        $user = $record->user;

        $dataToSend = [
            'type_of_request' => __('translate.access_request.options_type_of_request.' . $record->type_of_request),
            'property' => $record->property,
            'organization' => $organization?->organization_name,
            'name' => $user?->name,
            'email' => $user?->email,
        ];

        $userRoles = User::role('soporte')->pluck('email')->unique()->toArray();

        if (!empty($userRoles)) {
            Mail::to(array_map(fn($email) => new Address($email), $userRoles))
                ->send(new AccesPending($dataToSend));
        }
    }
}
