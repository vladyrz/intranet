<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use App\Mail\LeaveStatus\LeavePending;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditLeaveRequest extends EditRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        $user = User::find($record->user_id);

        if (!$user) {
            return; // Evitamos errores si no existe el usuario
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'request_type' => $record->request_type,
        ];

        match ($record->request_status) {
            'pending' => Mail::to($user->email)->send(new LeavePending($data)),
            'approved' => Mail::to($user->email)->send(new LeavePending($data)),
            'denied' => Mail::to($user->email)->send(new LeavePending($data)),
            default => null,
        };
    }
}
