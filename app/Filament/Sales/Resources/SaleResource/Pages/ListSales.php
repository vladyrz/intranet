<?php

namespace App\Filament\Sales\Resources\SaleResource\Pages;

use App\Filament\Sales\Resources\SaleResource;
use App\Models\Sale;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make(__('resources.sales.tab_total_sales'))
                ->badge($this->orderBySaleStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.sales.tab_offers'))
                ->query(fn ($query) => $query->where('status', 'offered'))
                ->badge($this->orderBySaleStatus('offered') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.sales.tab_in_process'))
                ->query(fn ($query) => $query->where('status', 'in_process'))
                ->badge($this->orderBySaleStatus('in_process') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.sales.tab_approved'))
                ->query(fn ($query) => $query->where('status', 'approved'))
                ->badge($this->orderBySaleStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.sales.tab_signed'))
                ->query(fn ($query) => $query->where('status', 'signed'))
                ->badge($this->orderBySaleStatus('signed') ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make(__('resources.sales.tab_rejected'))
                ->query(fn ($query) => $query->where('status', 'rejected'))
                ->badge($this->orderBySaleStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderBySaleStatus(string $status = null) {
        if(blank($status)){
            return Sale::count();
        }
        return Sale::where('status', $status)->count();
    }
}
