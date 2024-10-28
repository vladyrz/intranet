<?php

namespace App\Filament\Soporte\Resources\OrganizationContactResource\Pages;

use App\Filament\Soporte\Resources\OrganizationContactResource;
use App\Models\OrganizationContact;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationContacts extends ListRecords
{
    protected static string $resource = OrganizationContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')
                ->label(__('resources.organization_contact.tab_total_contacts'))
                ->badge($this->orderByContactType() ?? 0),
            'Adjusted assets' => Tab::make('Adjusted assets')
                ->label(__('resources.organization_contact.tab_adjudicated_assets'))
                ->query(fn ($query) => $query->where('contact_type', 'adjudicated_assets'))
                ->badge($this->orderByContactType('adjudicated_assets') ?? 0),
            'Cotizations' => Tab::make('Cotizations')
                ->label(__('resources.organization_contact.tab_cotizations'))
                ->query(fn ($query) => $query->where('contact_type', 'cotizations'))
                ->badge($this->orderByContactType('cotizations') ?? 0),
            'Billing' => Tab::make('Billing')
                ->label(__('resources.organization_contact.tab_billing'))
                ->query(fn ($query) => $query->where('contact_type', 'billing'))
                ->badge($this->orderByContactType('billing') ?? 0),
        ];
    }

    public function orderByContactType(string $contact_type = null) {
        if (blank($contact_type)) {
            return OrganizationContact::count();
        }
        return OrganizationContact::where('contact_type', $contact_type)->count();
    }
}
