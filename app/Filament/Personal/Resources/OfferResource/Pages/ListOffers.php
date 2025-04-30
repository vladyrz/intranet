<?php

namespace App\Filament\Personal\Resources\OfferResource\Pages;

use App\Filament\Personal\Resources\OfferResource;
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

    public function getTabs(): array {
        $user_id = auth()->user()->id;
        return [
            null => Tab::make(__('resources.offer.tab_total_offers'))
                ->badge($this->orderByOfferStatus(null, $user_id) ?? 0)
                ->badgeColor(Color::Amber)
                ->query(fn ($query) => $query->where('user_id', $user_id)),
            Tab::make(__('resources.offer.tab_pending'))
                ->query(fn ($query) => $query->where('offer_status', 'pending')->where('user_id', $user_id))
                ->badge($this->orderByOfferStatus('pending', $user_id) ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.offer.tab_sent'))
                ->query(fn ($query) => $query->where('offer_status', 'sent')->where('user_id', $user_id))
                ->badge($this->orderByOfferStatus('sent', $user_id) ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.offer.tab_approved'))
                ->query(fn ($query) => $query->where('offer_status', 'approved')->where('user_id', $user_id))
                ->badge($this->orderByOfferStatus('approved', $user_id) ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.offer.tab_rejected'))
                ->query(fn ($query) => $query->where('offer_status', 'rejected')->where('user_id', $user_id))
                ->badge($this->orderByOfferStatus('rejected', $user_id) ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.offer.tab_signed'))
                ->query(fn ($query) => $query->where('offer_status', 'signed')->where('user_id', $user_id))
                ->badge($this->orderByOfferStatus('signed', $user_id) ?? 0)
                ->badgeColor(Color::Teal),
        ];
    }

    public function orderByOfferStatus(?string $status = null, $user_id = null) {
        $query = Offer::where('user_id', $user_id);
        if(blank($status)){
            return $query->count();
        }
        return $query->where('offer_status', $status)->count();
    }
}
