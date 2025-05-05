<?php

namespace App\Filament\Rrhh\Resources\CustomerReportResource\Pages;

use App\Filament\Rrhh\Resources\CustomerReportResource;
use App\Models\CustomerReport;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListCustomerReports extends ListRecords
{
    protected static string $resource = CustomerReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.customer_report.tab_total_reports'))
                ->badge($this->orderByStatus() ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.customer_report.tab_pending'))
                ->query(fn ($query) => $query->where('report_status', 'pending'))
                ->badge($this->orderByStatus('pending') ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.customer_report.tab_approved'))
                ->query(fn ($query) => $query->where('report_status', 'approved'))
                ->badge($this->orderByStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.customer_report.tab_rejected'))
                ->query(fn ($query) => $query->where('report_status', 'rejected'))
                ->badge($this->orderByStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    private function orderByStatus(?string $status =null){
        if(blank($status)){
            return CustomerReport::count();
        }
        return CustomerReport::where('report_status', $status)->count();
    }
}
