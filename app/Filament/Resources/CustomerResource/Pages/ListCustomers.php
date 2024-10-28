<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
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

    public function getTabs(): array {
        return [
            null => Tab::make('All')
                ->badge($this->orderByCustomerType() ?? 0)
                ->badgeColor(Color::Orange)
                ->label(__('resources.customer.tab_total_customers')),
            'Buyer' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'buyer'))
                ->badge($this->orderByCustomerType('buyer') ?? 0)
                ->badgeColor(Color::Amber)
                ->label(__('resources.customer.tab_buyer')),
            'Seller' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'seller'))
                ->badge($this->orderByCustomerType('seller') ?? 0)
                ->badgeColor(Color::Indigo)
                ->label(__('resources.customer.tab_seller')),
            'Investor' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'investor'))
                ->badge($this->orderByCustomerType('investor') ?? 0)
                ->badgeColor(Color::Green)
                ->label(__('resources.customer.tab_investor')),
            'Tenant' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'tenant'))
                ->badge($this->orderByCustomerType('tenant') ?? 0)
                ->badgeColor(Color::Teal)
                ->label(__('resources.customer.tab_tenant')),
            'Other' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'other'))
                ->badge($this->orderByCustomerType('other') ?? 0)
                ->badgeColor(Color::Neutral)
                ->label(__('resources.customer.tab_other')),
        ];
    }

    public function orderByCustomerType(string $type = null) {
        if(blank($type)){
            return Customer::count();
        }
        return Customer::where('customer_type', $type)->count();
    }
}
