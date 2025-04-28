<?php

namespace App\Filament\Ops\Resources\AccesRequestResource\Pages;

use App\Filament\Ops\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesApproved;
use App\Mail\RequestStatus\AccesRejected;
use App\Mail\RequestStatus\AccesSent;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
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
}
