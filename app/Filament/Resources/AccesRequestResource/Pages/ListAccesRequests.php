<?php

namespace App\Filament\Resources\AccesRequestResource\Pages;

use App\Exports\RequestPerUserExport;
use App\Filament\Resources\AccesRequestResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Resources\Pages\ListRecords;
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
}
