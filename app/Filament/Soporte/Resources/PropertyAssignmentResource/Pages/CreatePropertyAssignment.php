<?php

namespace App\Filament\Soporte\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Soporte\Resources\PropertyAssignmentResource;
use App\Mail\AssignmentStatus\PropertyAssigned;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePropertyAssignment extends CreateRecord
{
    protected static string $resource = PropertyAssignmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['property_assigment_status'] = 'assigned';

        $assignedUser = User::find($data['user_id']);
        $organization = Organization::find($data['organization_id']);

        if ($assignedUser && $data['property_assigment_status'] === 'assigned') {
            $dataToSend = [
                'property_info' => $data['property_info'],
                'organization' => $organization ? $organization->organization_name : 'Desconocido/a',
                'name' => $assignedUser->name,
                'email' => $assignedUser->email,
            ];

            Mail::to($assignedUser->email)->send(new PropertyAssigned($dataToSend));
        }

        return $data;
    }
}
