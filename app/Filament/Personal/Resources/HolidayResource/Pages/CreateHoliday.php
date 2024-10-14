<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Filament\Personal\Resources\HolidayResource;
use App\Mail\HolidayPending;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';
        $superAdmins = User::role('super_admin')->get();
        $dataToSend = array (
            'day' => $data['day'],
            'name' => User::find($data['user_id'])->name,
            'email' => User::find($data['user_id'])->email,
        );

        foreach ($superAdmins as $admin) {
            Mail::to($admin)->send(new HolidayPending($dataToSend));
        }

        // Notification::make()
        //     ->title('Solicitud de Vacaciones')
        //     ->warning()
        //     ->body("El día ".$data['day'].' está pendiente de aprobar')
        //     ->send();

        $recipient = auth()->user();

        Notification::make()
            ->title('Solicitud de Vacaciones')
            ->body("El día ".$data['day'].' está pendiente de aprobar')
            ->sendToDatabase($recipient);
    
        return $data;
    }
}
