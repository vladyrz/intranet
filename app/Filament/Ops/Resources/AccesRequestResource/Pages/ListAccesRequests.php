<?php

namespace App\Filament\Ops\Resources\AccesRequestResource\Pages;

use App\Filament\Ops\Resources\AccesRequestResource;
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

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.acces_request.tab_total_acces_requests'))
                ->badge($this->orderByRequestStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.acces_request.tab_pending'))
                ->query(fn ($query) => $query->where('request_status', 'pending'))
                ->badge($this->orderByRequestStatus('pending') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.acces_request.tab_sent'))
                ->query(fn ($query) => $query->where('request_status', 'sent'))
                ->badge($this->orderByRequestStatus('sent') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.acces_request.tab_approved'))
                ->query(fn ($query) => $query->where('request_status', 'approved'))
                ->badge($this->orderByRequestStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.acces_request.tab_rejected'))
                ->query(fn ($query) => $query->where('request_status', 'rejected'))
                ->badge($this->orderByRequestStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderByRequestStatus(string $status = null) {
        if(blank($status)){
            return AccesRequest::count();
        }
        return AccesRequest::where('request_status', $status)->count();
    }
}
