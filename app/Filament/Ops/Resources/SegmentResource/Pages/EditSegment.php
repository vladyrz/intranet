<?php

namespace App\Filament\Ops\Resources\SegmentResource\Pages;

use App\Filament\Ops\Resources\SegmentResource;
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
