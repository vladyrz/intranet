<?php

namespace App\Filament\Resources\OrganizationContactResource\Pages;

use App\Filament\Resources\OrganizationContactResource;
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

    public function getTabs(): array {
        return [
            null => Tab::make('All')
                ->label(__('resources.organization_contact.tab_total_contacts'))
                ->badge($this->orderByOrganizationType() ?? 0),
            'Adjudicated assets' => Tab::make()
                ->query(fn ($query) => $query->where('contact_type', 'adjudicated_assets'))
                ->badge($this->orderByOrganizationType('adjudicated_assets') ?? 0)
                ->label(__('resources.organization_contact.tab_adjudicated_assets')),
            'Cotizations' => Tab::make()
                ->query(fn ($query) => $query->where('contact_type', 'cotizations'))
                ->badge($this->orderByOrganizationType('cotizations') ?? 0)
                ->label(__('resources.organization_contact.tab_cotizations')),
            'Billing' => Tab::make()
                ->query(fn ($query) => $query->where('contact_type', 'billing'))
                ->badge($this->orderByOrganizationType('billing') ?? 0)
                ->label(__('resources.organization_contact.tab_billing')),
        ];
    }

    public function orderByOrganizationType(string $type = null) {
        if(blank($type)){
            return OrganizationContact::count();
        }
        return OrganizationContact::where('contact_type', $type)->count();
    }
}
