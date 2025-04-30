<?php

namespace App\Filament\Personal\Resources\PersonalCustomerResource\Pages;

use App\Filament\Personal\Resources\PersonalCustomerResource;
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
        $user_id = auth()->user()->id;
        return [
            null => Tab::make(__('resources.customer.tab_total_customers'))
                ->badge($this->orderByCustomerType(null, $user_id) ?? 0)
                ->badgeColor(Color::Orange)
                ->query(fn ($query) => $query->where('user_id', $user_id)),
            Tab::make(__('resources.customer.tab_buyer'))
                ->query(fn ($query) => $query->where('customer_type', 'buyer')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('buyer', $user_id) ?? 0)
                ->badgeColor(Color::Gray),
            Tab::make(__('resources.customer.tab_seller'))
                ->query(fn ($query) => $query->where('customer_type', 'seller')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('seller', $user_id) ?? 0)
                ->badgeColor(Color::Purple),
            Tab::make(__('resources.customer.tab_investor'))
                ->query(fn ($query) => $query->where('customer_type', 'investor')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('investor', $user_id) ?? 0)
                ->badgeColor(Color::Blue),
            Tab::make(__('resources.customer.tab_tenant'))
                ->query(fn ($query) => $query->where('customer_type', 'tenant')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('tenant', $user_id) ?? 0)
                ->badgeColor(Color::Rose),
            Tab::make(__('resources.customer.tab_other'))
                ->query(fn ($query) => $query->where('customer_type', 'other')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('other', $user_id) ?? 0)
                ->badgeColor(Color::Neutral),
        ];
    }

    public function orderByCustomerType(?string $type = null, $user_id = null) {
        $query = PersonalCustomer::where('user_id', $user_id);
        if(blank($type)){
            return $query->count();
        }
        return $query->where('customer_type', $type)->count();
    }
}
