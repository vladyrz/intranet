<?php

namespace App\Filament\Personal\Resources\LeaveRequestResource\Pages;

use App\Filament\Personal\Resources\LeaveRequestResource;
use App\Mail\LeaveStatus\LeavePending;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        $user = $record->user;

        $dataToSend = [
            'request_type' => __('translate.leave_request.options_request_types.' . $record->request_type),
            'name' => $user?->name,
            'email' => $user?->email,
        ];

        $userRoles = User::role('rrhh')->pluck('email')->unique()->toArray();

        if (!empty($userRoles)) {
            Mail::to(array_map(fn($email) => new Address($email), $userRoles))
                ->cc(new Address($user->email))
                ->send(new LeavePending($dataToSend));
        }
    }
}
