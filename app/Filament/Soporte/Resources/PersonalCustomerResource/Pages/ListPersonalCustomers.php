<?php

namespace App\Filament\Soporte\Resources\PersonalCustomerResource\Pages;

use App\Filament\Soporte\Resources\PersonalCustomerResource;
use App\Models\PersonalCustomer;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListPersonalCustomers extends ListRecords
{
    protected static string $resource = PersonalCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make(__('resources.customer.tab_total_customers'))
                ->badge($this->orderByCustomerType() ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.customer.tab_buyer'))
                ->badge($this->orderByCustomerType('buyer') ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.customer.tab_seller'))
                ->badge($this->orderByCustomerType('seller') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.customer.tab_investor'))
                ->badge($this->orderByCustomerType('investor') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.customer.tab_tenant'))
                ->badge($this->orderByCustomerType('tenant') ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make(__('resources.customer.tab_other'))
                ->badge($this->orderByCustomerType('other') ?? 0)
                ->badgeColor(Color::Neutral),
        ];
    }

    public function orderByCustomerType(string $type = null) {
        if(blank($type)){
            return PersonalCustomer::count();
        }
        return PersonalCustomer::where('customer_type', $type)->count();
    }
}
