<?php

namespace App\Filament\Services\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Services\Resources\PropertyAssignmentResource;
use App\Mail\AssignmentStatus\PropertyApproved;
use App\Mail\AssignmentStatus\PropertyFinished;
use App\Mail\AssignmentStatus\PropertyPublished;
use App\Mail\AssignmentStatus\PropertyRejected;
use App\Mail\AssignmentStatus\PropertySubmitted;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditPropertyAssignment extends EditRecord
{
    protected static string $resource = PropertyAssignmentResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function afterSave(): void
    {
        $record = $this->record;

        $user = User::find($record->user_id);

        if (!$user) {
            return; // Seguridad: si no existe usuario, no seguimos
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'property_info' => $record->property_info,
        ];

        match ($record->property_assignment_status) {
            'approved' => Mail::to($user->email)->send(new PropertyApproved($data)),
            'rejected' => Mail::to($user->email)->send(new PropertyRejected($data)),
            'published' => Mail::to($user->email)->send(new PropertyPublished($data)),
            'finished' => Mail::to($user->email)->send(new PropertyFinished($data)),
            'submitted' => Mail::to($user->email)->send(new PropertySubmitted($data)),
            default => null,
        };
    }
}
