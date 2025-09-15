<?php

namespace App\Filament\Rrhh\Resources\AdRequestResource\Pages;

use App\Filament\Rrhh\Resources\AdRequestResource;
use App\Helpers\FilamentUrlHelper;
use App\Mail\AdStatusMail;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditAdRequest extends EditRecord
{
    protected static string $resource = AdRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $solicitante = User::find($record->user_id);
        if (!$solicitante) return;

        $dataSolicitante = [
            'name'            => $solicitante->name,
            'email'           => $solicitante->email,
            'url'             => FilamentUrlHelper::getResourceUrl(
                $solicitante,
                AdRequestResource::class,
                $record,
            )
        ];

        if (in_array($record->status, ['scheduled', 'stopped', 'finished'])) {
            Mail::to($solicitante->email)->send(
                new AdStatusMail($dataSolicitante, $record->status)
            );
        }

        $admins = User::role(['rrhh'])
            ->where('email', '!=', $solicitante->email)
            ->get();

        foreach ($admins as $admin) {
            $dataToAdmin = [
                'name'            => $solicitante->name,
                'email'           => $solicitante->email,
                'url'             => FilamentUrlHelper::getResourceUrl(
                    $admin,
                    AdRequestResource::class,
                    $record,
                )
            ];

            Mail::to($admin->email)->send(
                new AdStatusMail($dataToAdmin, $record->status)
            );
        }
    }
}
