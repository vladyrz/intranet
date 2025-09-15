<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use App\Helpers\FilamentUrlHelper;
use App\Mail\OfferStatusMail;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

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
            'property' => $record->property_name,
            'url'      => FilamentUrlHelper::getResourceUrl(
                $solicitante,
                OfferResource::class,
                $record,
            ),
        ];

        if (in_array($record->offer_status, ['received', 'sent', 'approved', 'rejected', 'signed'])) {
            Mail::to($solicitante->email)->send(
                new OfferStatusMail($dataSolicitante, $record->offer_status)
            );
        }

        // Send the email to administrative users
        $admins = User::role(['soporte', 'ventas', 'servicio_al_cliente', 'gerente'])
            ->where('email', '!=', $solicitante->email)
            ->get();

        foreach ($admins as $admin) {
            $dataToAdmin = [
                'name'     => $solicitante->name,
                'email'    => $solicitante->email,
                'property' => $record->property_name,
                'url'      => FilamentUrlHelper::getResourceUrl(
                    $admin,
                    OfferResource::class,
                    $record,
                ),
            ];

            Mail::to($admin->email)->send(
                new OfferStatusMail($dataToAdmin, $record->offer_status)
            );
        }

        // Extra: Send email to external account when signed
        if ($record->offer_status === 'signed') {
            $dataToExternal = [
                'name'     => $solicitante->name,
                'email'    => $solicitante->email,
                'property' => $record->property_name,
                'url'      => FilamentUrlHelper::getResourceUrlForPanel(
                    'contabilidad',
                    OfferResource::class,
                    $record,
                ),
            ];

            Mail::to('contabilidad@g-easypro.com')->send(
                new OfferStatusMail($dataToExternal, $record->offer_status)
            );
        }
    }
}
