<?php

namespace App\Filament\Soporte\Resources\OfferResource\Pages;

use App\Exports\offers;
use App\Exports\OffersPerUserExport;
use App\Filament\Soporte\Resources\OfferResource;
use App\Models\Offer;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Maatwebsite\Excel\Facades\Excel;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportar_reporte')
                ->label('Exportar reporte por usuario')
                ->color('success')
                ->icon('heroicon-m-arrow-down-tray')
                ->form([
                    Grid::make(3)->schema([
                        Select::make('month')
                        ->label('Mes')
                        ->options(collect(range(1, 12))->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->locale('es')->translatedFormat('F')]))
                        ->default(now()->month)
                        ->required()
                        ->reactive(),

                        Select::make('year')
                            ->label('Año')
                            ->options(fn() => collect(range(now()->year - 1, now()->year))->reverse()->mapWithKeys(fn($y) => [$y => $y]))
                            ->default(now()->year)
                            ->required(),

                        Select::make('week')
                            ->label('Semana (opcional)')
                            ->options(function (Get $get) {
                                $month = $get('month');
                                $weeks = [];

                                if ($month) {
                                    $start = Carbon::create(now()->year, $month)->startOfMonth();
                                    $end = $start->copy()->endOfMonth();

                                    while ($start->lte($end)) {
                                        $weekNumber = $start->isoWeek();
                                        $weeks[$weekNumber] = 'Semana ' . $weekNumber;
                                        $start->addDay();
                                    }
                                }

                                return $weeks;
                            })
                    ])
                ])
                ->action(function (array $data) {
                    return Excel::download(
                        new OffersPerUserExport($data['month'], $data['year'], $data['week']),
                        'reporte-ofertas-por-usuario.xlsx'
                    );
                }),

            Action::make('export')
                ->label('Exportar todas las ofertas')
                ->color('success')
                ->icon('heroicon-m-cloud-arrow-down')
                ->action(function () {
                    return Excel::download(new offers(), 'ofertas.xlsx');
                }),

            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.offer.tab_total_offers'))
                ->badge($this->orderByOfferStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.offer.tab_pending'))
                ->query(fn ($query) => $query->where('offer_status', 'pending'))
                ->badge($this->orderByOfferStatus('pending') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.offer.tab_received'))
                ->query(fn ($query) => $query->where('offer_status', 'received'))
                ->badge($this->orderByOfferStatus('received') ?? 0)
                ->badgeColor(Color::Gray),
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

    public function orderByOfferStatus(?string $status = null){
        if(blank($status)){
            return Offer::count();
        }
        return Offer::where('offer_status', $status)->count();
    }
}
