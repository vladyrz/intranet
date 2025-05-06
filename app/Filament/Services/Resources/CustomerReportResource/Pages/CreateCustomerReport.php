<?php

namespace App\Filament\Services\Resources\CustomerReportResource\Pages;

use App\Filament\Services\Resources\CustomerReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerReport extends CreateRecord
{
    protected static string $resource = CustomerReportResource::class;
}
