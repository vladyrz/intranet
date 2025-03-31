<?php

namespace App\Filament\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Resources\PropertyAssignmentResource;
use App\Mail\AssignmentStatus\PropertyApproved;
use App\Mail\AssignmentStatus\PropertyFinished;
use App\Mail\AssignmentStatus\PropertyPublished;
use App\Mail\AssignmentStatus\PropertyRejected;
use App\Mail\AssignmentStatus\PropertySubmitted;
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
            Mail::to($user)->send(new PropertyApproved($data));
        }

        //Send Email only if Rejected

        else if($record->property_assignment_status == 'rejected') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertyRejected($data));
        }

        //Send Email only if Published
        else if($record->property_assignment_status == 'published') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertyPublished($data));
        }

        //Send Email only if Finished
        else if($record->property_assignment_status == 'finished') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertyFinished($data));
        }

        //Send Email only if Submitted
        else if($record->property_assignment_status == 'submitted') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'property_info' => $record->property_info
            );
            Mail::to($user)->send(new PropertySubmitted($data));
        }

        return $record;
    }
}
