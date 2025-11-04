<?php

namespace App\Filament\Personal\Resources\CollaborationRequestResource\Pages;

use App\Filament\Personal\Resources\CollaborationRequestResource;
use App\Helpers\FilamentUrlHelper;
use App\Mail\CollabNotification;
use App\Models\PersonalCustomer;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateCollaborationRequest extends CreateRecord
{
    protected static string $resource = CollaborationRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $customer = PersonalCustomer::find($record->personal_customer_id);
        $solicitante = $record->user;
        $admins = User::role(['ventas', 'servicio_al_cliente', 'rrhh'])->get();

        foreach ($admins as $admin) {
            $dataToSend = [
                'customer'        => $customer?->full_name,
                'client_budget'   => $record->client_budget,
                'name'            => $solicitante->name,
                'email'           => $solicitante->email,
                'url'             => FilamentUrlHelper::getResourceUrl(
                    $admin,
                    CollaborationRequestResource::class,
                    $record,
                ),
            ];

            Mail::to(new Address($admin->email))
                ->send(new CollabNotification($dataToSend));
        }

        if ($solicitante && $solicitante->hasRole('panel_user')) {
            $dataToSend = [
                'customer'        => $customer?->full_name,
                'client_budget'   => $record->client_budget,
                'name'            => $solicitante->name,
                'email'           => $solicitante->email,
                'url'             => FilamentUrlHelper::getResourceUrl(
                    $solicitante,
                    CollaborationRequestResource::class,
                    $record,
                ),
            ];

            Mail::to(new Address($solicitante->email))
                ->send(new CollabNotification($dataToSend));
        }
    }
}
