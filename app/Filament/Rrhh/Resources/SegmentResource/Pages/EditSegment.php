<?php

namespace App\Filament\Rrhh\Resources\SegmentResource\Pages;

use App\Filament\Rrhh\Resources\SegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSegment extends EditRecord
{
    protected static string $resource = SegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
