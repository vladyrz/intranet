<?php

namespace App\Filament\Ops\Resources\CustomerResource\Pages;

use App\Filament\Ops\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.customer.tab_total_customers'))
                ->badge($this->orderbyCustomerType() ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.customer.tab_buyer'))
                ->query(fn ($query) => $query->where('customer_type', 'buyer'))
                ->badge($this->orderbyCustomerType('buyer') ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.customer.tab_seller'))
                ->query(fn ($query) => $query->where('customer_type', 'seller'))
                ->badge($this->orderbyCustomerType('seller') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.customer.tab_investor'))
                ->query(fn ($query) => $query->where('customer_type', 'investor'))
                ->badge($this->orderbyCustomerType('investor') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.customer.tab_tenant'))
                ->query(fn ($query) => $query->where('customer_type', 'tenant'))
                ->badge($this->orderbyCustomerType('tenant') ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make(__('resources.customer.tab_other'))
                ->query(fn ($query) => $query->where('customer_type', 'other'))
                ->badge($this->orderbyCustomerType('other') ?? 0)
                ->badgeColor(Color::Neutral),
        ];
    }

    public function orderbyCustomerType(string $type = null) {
        if (blank($type)) {
            return Customer::count();
        }
        return Customer::where('customer_type', $type)->count();
    }
}
