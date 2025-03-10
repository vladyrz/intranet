<?php

namespace App\Filament\Personal\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Personal\Resources\PropertyAssignmentResource;
use App\Mail\AssignmentStatus\PropertyPending;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreatePropertyAssignment extends CreateRecord
{
    protected static string $resource = PropertyAssignmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $userRole = User::role('servicio_al_cliente')->get('email');
        $dataToSend = array (
            'property_info' => $data['property_info'],
            'organization' => Organization::find($data['organization_id'])->organization_name,
            'name' => User::find($data['user_id'])->name,
            'email' => User::find($data['user_id'])->email,
        );

        foreach ($userRole as $admin) {
            Mail::to($admin)->send(new PropertyPending($dataToSend));
        }

        // $recipient = auth()->user();

        // Notification::make()
        //     ->title('Solicitud de Asignación de Propiedad')
        //     ->body("La propiedad ".$data['property_info'].' está pendiente de aprobar')
        //     ->sendToDatabase($recipient);

        return $data;
    }
}
