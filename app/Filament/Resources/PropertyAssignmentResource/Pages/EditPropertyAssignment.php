<?php

namespace App\Filament\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Resources\PropertyAssignmentResource;
use App\Mail\PropertyAssignmentApproved;
use App\Mail\PropertyAssignmentRejected;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EditPropertyAssignment extends EditRecord
{
    protected static string $resource = PropertyAssignmentResource::class;

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
        if ($record->property_assignment_status == 'approved') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertyAssignmentApproved($data));
            $recipient = $user;

            Notification::make()
                ->title('Solicitud de Asignación de Propiedad')
                ->body("La propiedad ".$data['property_info'].' ha sido aprobada')
                ->sendToDatabase($recipient);
        }

        //Send Email only if Rejected

        else if($record->property_assignment_status == 'rejected') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertyAssignmentRejected($data));
            $recipient = $user;

            Notification::make()
                ->title('Solicitud de Asignación de Propiedad')
                ->body("La propiedad ".$data['property_info'].' ha sido rechazada')
                ->sendToDatabase($recipient);
        }

        return $record;
    }
}
