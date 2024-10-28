<?php

namespace App\Filament\Personal\Resources\CustomerResource\Pages;

use App\Filament\Personal\Resources\CustomerResource;
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
        $user_id = auth()->user()->id;
        return [
            null => Tab::make('All')
                ->badge($this->orderByCustomerType(null, $user_id) ?? 0)
                ->badgeColor(Color::Orange)
                ->label(__('resources.customer.tab_total_customers'))
                ->query(fn ($query) => $query->where('user_id', $user_id)),
            'Buyer' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'buyer')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('buyer', $user_id) ?? 0)
                ->badgeColor(Color::Gray)
                ->label(__('resources.customer.tab_buyer')),
            'Seller' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'seller')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('seller', $user_id) ?? 0)
                ->badgeColor(Color::Purple)
                ->label(__('resources.customer.tab_seller')),
            'Investor' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'investor')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('investor', $user_id) ?? 0)
                ->badgeColor(Color::Blue)
                ->label(__('resources.customer.tab_investor')),
            'Tenant' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'tenant')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('tenant', $user_id) ?? 0)
                ->badgeColor(Color::Rose)
                ->label(__('resources.customer.tab_tenant')),
            'Other' => Tab::make()
                ->query(fn ($query) => $query->where('customer_type', 'other')->where('user_id', $user_id))
                ->badge($this->orderByCustomerType('other', $user_id) ?? 0)
                ->badgeColor(Color::Neutral)
                ->label(__('resources.customer.tab_other')),
        ];
    }

    public function orderByCustomerType(string $type = null, $user_id = null) {
        $query = Customer::where('user_id', $user_id);
        if(blank($type)){
            return $query->count();
        }
        return $query->where('customer_type', $type)->count();
    }
}
