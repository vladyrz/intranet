<?php

namespace App\Filament\Ops\Resources\OperationResource\Pages;

use App\Filament\Ops\Resources\OperationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOperation extends CreateRecord
{
    protected static string $resource = OperationResource::class;
}
