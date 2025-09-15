<?php

namespace App\Filament\Sales\Resources\AccesRequestResource\Pages;

use App\Filament\Sales\Resources\AccesRequestResource;
use App\Helpers\FilamentUrlHelper;
use App\Mail\AccesStatusMail;
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

        // Get the requester
        $solicitante = User::find($record->user_id);
        if (!$solicitante) return;

        // Send the mail to the requester
        $dataSolicitante = [
            'name'     => $solicitante->name,
            'email'    => $solicitante->email,
            'property' => $record->property,
            'url'      => FilamentUrlHelper::getResourceUrl(
                $solicitante,
                AccesRequestResource::class,
                $record,
            ),
        ];

        if (in_array($record->request_status, ['received', 'sent', 'approved', 'rejected'])) {
            Mail::to($solicitante->email)->send(
                new AccesStatusMail($dataSolicitante, $record->request_status)
            );
        }

        // Send the email to administrative users
        $admins = User::role(['soporte', 'ventas', 'servicio_al_cliente', 'rrhh'])
            ->where('email', '!=', $solicitante->email)
            ->get();

        foreach ($admins as $admin) {
            $dataToAdmin = [
                'name'     => $solicitante->name,
                'email'    => $solicitante->email,
                'property' => $record->property,
                'url'      => FilamentUrlHelper::getResourceUrl(
                    $admin,
                    AccesRequestResource::class,
                    $record,
                ),
            ];

            Mail::to($admin->email)->send(
                new AccesStatusMail($dataToAdmin, $record->request_status)
            );
        }
    }
}
