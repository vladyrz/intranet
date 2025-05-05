<?php

namespace App\Filament\Rrhh\Resources\OfferResource\Pages;

use App\Filament\Rrhh\Resources\OfferResource;
use App\Models\Offer;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.offer.tab_total_offers'))
                ->badge($this->orderByStatus() ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.offer.tab_pending'))
                ->query(fn ($query) => $query->where('offer_status', 'pending'))
                ->badge($this->orderByStatus('pending') ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.offer.tab_sent'))
                ->query(fn ($query) => $query->where('offer_status', 'sent'))
                ->badge($this->orderByStatus('sent') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.offer.tab_approved'))
                ->query(fn ($query) => $query->where('offer_status', 'approved'))
                ->badge($this->orderByStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.offer.tab_rejected'))
                ->query(fn ($query) => $query->where('offer_status', 'rejected'))
                ->badge($this->orderByStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.offer.tab_signed'))
                ->query(fn ($query) => $query->where('offer_status', 'signed'))
                ->badge($this->orderByStatus('signed') ?? 0)
                ->badgeColor(Color::Teal),
        ];
    }

    private function orderByStatus(?string $status =null){
        if(blank($status)){
            return Offer::count();
        }
        return Offer::where('offer_status', $status)->count();
    }
}
