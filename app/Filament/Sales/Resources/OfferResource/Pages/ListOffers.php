<?php

namespace App\Filament\Sales\Resources\OfferResource\Pages;

use App\Filament\Sales\Resources\OfferResource;
use App\Models\Offer;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array {
        return [
            null => Tab::make(__('resources.offer.tab_total_offers'))
                ->badge($this->orderByOfferStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.offer.tab_pending'))
                ->query(fn ($query) => $query->where('offer_status', 'pending'))
                ->badge($this->orderByOfferStatus('pending') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.offer.tab_sent'))
                ->query(fn ($query) => $query->where('offer_status', 'sent'))
                ->badge($this->orderByOfferStatus('sent') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.offer.tab_approved'))
                ->query(fn ($query) => $query->where('offer_status', 'approved'))
                ->badge($this->orderByOfferStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.offer.tab_rejected'))
                ->query(fn ($query) => $query->where('offer_status', 'rejected'))
                ->badge($this->orderByOfferStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.offer.tab_signed'))
                ->query(fn ($query) => $query->where('offer_status', 'signed'))
                ->badge($this->orderByOfferStatus('signed') ?? 0)
                ->badgeColor(Color::Teal),
        ];
    }

    public function orderByOfferStatus(string $status = null) {
        if(blank($status)){
            return Offer::count();
        }
        return Offer::where('offer_status', $status)->count();
    }
}
