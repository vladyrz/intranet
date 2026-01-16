<?php

namespace App\Filament\Resources\CustomerReportResource\Pages;

use App\Exports\Customers;
use App\Filament\Resources\CustomerReportResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListCustomerReports extends ListRecords
{
    protected static string $resource = CustomerReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('export')
                ->label('Exportar reporte')
                ->color('success')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(function () {
                    return Excel::download(
                        new Customers(),
                        'reporte-de-clientes.xlsx'
                    );
                }),
        ];
    }
}
