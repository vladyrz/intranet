<?php

namespace App\Filament\Resources\CustomerReportResource\Pages;

use App\Filament\Resources\CustomerReportResource;
use App\Mail\ReportStatus\Approved;
use App\Mail\ReportStatus\Rejected;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditCustomerReport extends EditRecord
{
    protected static string $resource = CustomerReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        $user = User::find($record->user_id);

        if (!$user) {
            return; // Evitar errores si no se encuentra el usuario
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'property_name' => $record->property_name,
            'customer_name' => $record->customer_name,
        ];

        switch ($record->report_status) {
            case 'approved':
                Mail::to($user->email)->send(new Approved($data));
                break;

            case 'rejected':
                Mail::to($user->email)->send(new Rejected($data));
                break;
        }
    }
}
