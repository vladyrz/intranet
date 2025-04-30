<?php

namespace App\Filament\Personal\Resources\CustomerReportResource\Pages;

use App\Filament\Personal\Resources\CustomerReportResource;
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
        $user_id = auth()->user()->id;
        return [
            null => Tab::make(__('resources.customer_report.tab_total_reports'))
                ->badge($this->orderByReportStatus(null, $user_id) ?? 0)
                ->badgeColor(Color::Purple)
                ->query(fn ($query) => $query->where('user_id', $user_id)),
            Tab::make(__('resources.customer_report.tab_pending'))
                ->query(fn ($query) => $query->where('report_status', 'pending')->where('user_id', $user_id))
                ->badge($this->orderByReportStatus('pending', $user_id) ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.customer_report.tab_approved'))
                ->query(fn ($query) => $query->where('report_status', 'approved')->where('user_id', $user_id))
                ->badge($this->orderByReportStatus('approved', $user_id) ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.customer_report.tab_rejected'))
                ->query(fn ($query) => $query->where('report_status', 'rejected')->where('user_id', $user_id))
                ->badge($this->orderByReportStatus('rejected', $user_id) ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderByReportStatus(?string $status = null, $user_id = null) {
        $query = CustomerReport::where('user_id', $user_id);
        if(blank($status)){
            return $query->count();
        }
        return $query->where('report_status', $status)->count();
    }
}
