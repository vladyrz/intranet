<?php

namespace App\Filament\Services\Resources\ProjectResource\Pages;

use App\Filament\Services\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
}
