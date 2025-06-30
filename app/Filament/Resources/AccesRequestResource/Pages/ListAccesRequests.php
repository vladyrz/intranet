<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Exports\RequestPerUserExport;
use App\Filament\Resources\AccesRequestResource;
use App\Models\AccesRequest;
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

class ListAccesRequests extends ListRecords
{
    protected static string $resource = AccesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('exportar_reporte')
                ->label('Exportar reporte')
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
                        new RequestPerUserExport($data['month'], $data['year'], $data['week']),
                        'reporte-solicitudes-por-usuario.xlsx'
                    );
                })
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
            Tab::make(__('resources.acces_request.tab_received'))
                ->query(fn ($query) => $query->where('request_status', 'received'))
                ->badge($this->orderByRequestStatus('received') ?? 0)
                ->badgeColor(Color::Gray),
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

    public function orderByRequestStatus(?string $status = null) {
        if(blank($status)){
            return AccesRequest::count();
        }
        return AccesRequest::where('request_status', $status)->count();
    }
}
