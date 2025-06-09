<?php

namespace App\Filament\Services\Resources\AccesRequestResource\Pages;

use App\Filament\Services\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesApproved;
use App\Mail\RequestStatus\AccesReceived;
use App\Mail\RequestStatus\AccesRejected;
use App\Mail\RequestStatus\AccesSent;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditAccesRequest extends EditRecord
{
    protected static string $resource = AccesRequestResource::class;

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
            'property' => $record->property,
        ];

        match ($record->request_status) {
            'received' => Mail::to($user->email)->send(new AccesReceived($data)),
            'sent' => Mail::to($user->email)->send(new AccesSent($data)),
            'approved' => Mail::to($user->email)->send(new AccesApproved($data)),
            'rejected' => Mail::to($user->email)->send(new AccesRejected($data)),
            default => null,
        };
    }
}
