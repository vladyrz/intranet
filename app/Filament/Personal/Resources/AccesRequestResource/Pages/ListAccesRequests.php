<?php

namespace App\Filament\Personal\Resources\AccesRequestResource\Pages;

use App\Filament\Personal\Resources\AccesRequestResource;
use App\Models\AccesRequest;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListAccesRequests extends ListRecords
{
    protected static string $resource = AccesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        $user_id = auth()->user()->id;
        return [
            null => Tab::make(__('resources.acces_request.tab_total_acces_requests'))
                ->badge($this->orderByAccesRequestStatus(null, $user_id) ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.acces_request.tab_pending'))
                ->query(fn ($query) => $query->where('request_status', 'pending'))
                ->badge($this->orderByAccesRequestStatus('pending', $user_id) ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.acces_request.tab_received'))
                ->query(fn ($query) => $query->where('request_status', 'received'))
                ->badge($this->orderByAccesRequestStatus('received', $user_id) ?? 0)
                ->badgeColor(Color::Gray),
            Tab::make(__('resources.acces_request.tab_sent'))
                ->query(fn ($query) => $query->where('request_status', 'sent'))
                ->badge($this->orderByAccesRequestStatus('sent', $user_id) ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.acces_request.tab_approved'))
                ->query(fn ($query) => $query->where('request_status', 'approved'))
                ->badge($this->orderByAccesRequestStatus('approved', $user_id) ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.acces_request.tab_rejected'))
                ->query(fn ($query) => $query->where('request_status', 'rejected'))
                ->badge($this->orderByAccesRequestStatus('rejected', $user_id) ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderByAccesRequestStatus(?string $status = null, $user_id = null) {
        $query = AccesRequest::where('user_id', $user_id);
        if(blank($status)){
            return $query->count();
        }
        return $query->where('request_status', $status)->count();
    }
}
