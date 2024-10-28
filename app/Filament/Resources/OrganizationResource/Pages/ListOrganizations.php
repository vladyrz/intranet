<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListOrganizations extends ListRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make('All')
                ->badge($this->orderByOrganizationType() ?? 0)
                ->badgeColor(Color::Amber)
                ->label(__('resources.organization.tab_total_organizations')),
            'Banks' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'banks'))
                ->badge($this->orderByOrganizationType('banks') ?? 0)
                ->badgeColor(Color::Red)
                ->label(__('resources.organization.tab_banks')),
            'Cooperatives' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'cooperatives'))
                ->badge($this->orderByOrganizationType('cooperatives') ?? 0)
                ->badgeColor(Color::Sky)
                ->label(__('resources.organization.tab_cooperatives')),
            'Financial institutions' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'financial_institutions'))
                ->badge($this->orderByOrganizationType('financial_institutions') ?? 0)
                ->badgeColor(Color::Blue)
                ->label(__('resources.organization.tab_financial_institutions')),
            'Associations' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'associations'))
                ->badge($this->orderByOrganizationType('associations') ?? 0)
                ->badgeColor(Color::Orange)
                ->label(__('resources.organization.tab_associations')),
            'Funds' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'funds'))
                ->badge($this->orderByOrganizationType('funds') ?? 0)
                ->badgeColor(Color::hex('#4fa230'))
                ->label(__('resources.organization.tab_funds')),
            'Development and others' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'development_and_others'))
                ->badge($this->orderByOrganizationType('development_and_others') ?? 0)
                ->badgeColor(Color::Fuchsia)
                ->label(__('resources.organization.tab_development_and_others')),
            'Rent a car' => Tab::make()
                ->query(fn ($query) => $query->where('organization_type', 'rent_a_car'))
                ->badge($this->orderByOrganizationType('rent_a_car') ?? 0)
                ->badgeColor(Color::Green)
                ->label(__('resources.organization.tab_rent_a_car')),
        ];
    }

    public function orderByOrganizationType(string $type = null) {
        if(blank($type)){
            return Organization::count();
        }
        return Organization::where('organization_type', $type)->count();
    }
}
