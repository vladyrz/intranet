<?php

namespace App\Filament\Ops\Resources\DocumentResource\Pages;

use App\Filament\Ops\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;
}
