<?php

namespace App\Filament\Personal\Resources\CustomerReportResource\Pages;

use App\Filament\Personal\Resources\CustomerReportResource;
use App\Mail\ReportStatus\Pending;
use App\Models\Organization;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateCustomerReport extends CreateRecord
{
    protected static string $resource = CustomerReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $userRol = User::role('soporte')->get('email');

        $dataToSend = [
            'property_name' => $this->record->property_name,
            'organization' => Organization::find($this->record->organization_id)?->organization_name,
            'name' => $this->record->user->name,
            'email' => $this->record->user->email,
            'customer_name' => $this->record->customer_name,
            'customer_national_id' => $this->record->national_id,
        ];

        foreach ($userRol as $user) {
            Mail::to($user->email)->send(new Pending($dataToSend));
        }
    }
}
