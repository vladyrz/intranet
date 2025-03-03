<?php

namespace App\Filament\Personal\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Personal\Resources\PropertyAssignmentResource;
use App\Mail\PropertyAssignmentPending;
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
        $userRole = User::role('super_admin')->get();
        $dataToSend = array (
            'property_info' => $data['property_info'],
            'name' => User::find($data['user_id'])->name,
            'email' => User::find($data['user_id'])->email,
        );

        foreach ($userRole as $admin) {
            Mail::to($admin)->send(new PropertyAssignmentPending($dataToSend));
        }

        $recipient = auth()->user();

        Notification::make()
            ->title('Solicitud de Asignación de Propiedad')
            ->body("La propiedad ".$data['property_info'].' está pendiente de aprobar')
            ->sendToDatabase($recipient);

        return $data;
    }
}
