<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Filament\Resources\AccesRequestResource;
use App\Mail\RequestStatus\AccesSent;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateAccesRequest extends CreateRecord
{
    protected static string $resource = AccesRequestResource::class;
}
