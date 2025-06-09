<?php

namespace App\Filament\Services\Resources\CustomerReportResource\Pages;

use App\Filament\Services\Resources\CustomerReportResource;
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

    public function getTabs(): array {
        return [
            null => Tab::make(__('resources.customer_report.tab_total_reports'))
                ->badge($this->orderByReportStatus() ?? 0)
                ->badgeColor(Color::Orange),
            'Pending' => Tab::make(__('resources.customer_report.tab_pending'))
                ->query(fn ($query) => $query->where('report_status', 'pending'))
                ->badge($this->orderByReportStatus('pending') ?? 0)
                ->badgeColor(Color::Amber),
            'Received' => Tab::make(__('resources.customer_report.tab_received'))
                ->query(fn ($query) => $query->where('report_status', 'received'))
                ->badge($this->orderByReportStatus('received') ?? 0)
                ->badgeColor(Color::Indigo),
            'Approved' => Tab::make(__('resources.customer_report.tab_approved'))
                ->query(fn ($query) => $query->where('report_status', 'approved'))
                ->badge($this->orderByReportStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            'Rejected' => Tab::make(__('resources.customer_report.tab_rejected'))
                ->query(fn ($query) => $query->where('report_status', 'rejected'))
                ->badge($this->orderByReportStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderByReportStatus(?string $status = null) {
        if(blank($status)){
            return CustomerReport::count();
        }
        return CustomerReport::where('report_status', $status)->count();
    }
}
