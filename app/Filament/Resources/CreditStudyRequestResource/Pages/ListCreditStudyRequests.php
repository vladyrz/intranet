<?php

namespace App\Filament\Resources\CreditStudyRequestResource\Pages;

use App\Filament\Resources\CreditStudyRequestResource;
use App\Models\CreditStudyRequest;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListCreditStudyRequests extends ListRecords
{
    protected static string $resource = CreditStudyRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.credit_request.tab_total_requests'))
                ->badge($this->orderByStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.credit_request.tab_pending'))
                ->query(fn ($query) => $query->where('request_status', 'pending'))
                ->badge($this->orderByStatus('pending') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.credit_request.tab_approved'))
                ->query(fn ($query) => $query->where('request_status', 'approved'))
                ->badge($this->orderByStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.credit_request.tab_rejected'))
                ->query(fn ($query) => $query->where('request_status', 'rejected'))
                ->badge($this->orderByStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    public function orderByStatus(?string $status = null) {
        if (blank($status)) {
            return CreditStudyRequest::count();
        }
        return CreditStudyRequest::where('request_status', $status)->count();
    }
}
