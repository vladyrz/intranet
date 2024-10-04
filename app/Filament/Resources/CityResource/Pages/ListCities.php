<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use App\Models\City;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')->badge($this->orderByStates() ?? 0)->label('Todos'),
            'San José' => Tab::make()->query(fn ($query) => $query->where('state_id', 1))->badge($this->orderByStates(1) ?? 0),
            'Alajuela' => Tab::make()->query(fn ($query) => $query->where('state_id', 2))->badge($this->orderByStates(2) ?? 0),
            'Cartago' => Tab::make()->query(fn ($query) => $query->where('state_id', 3))->badge($this->orderByStates(3) ?? 0),
            'Heredia' => Tab::make()->query(fn ($query) => $query->where('state_id', 4))->badge($this->orderByStates(4) ?? 0),
            'Guanacaste' => Tab::make()->query(fn ($query) => $query->where('state_id', 5))->badge($this->orderByStates(5) ?? 0),
            'Puntarenas' => Tab::make()->query(fn ($query) => $query->where('state_id', 6))->badge($this->orderByStates(6) ?? 0),
            'Limón' => Tab::make()->query(fn ($query) => $query->where('state_id', 7))->badge($this->orderByStates(7) ?? 0),
        ];
    }

    public function orderByStates(string $statesId = null){
        if (blank($statesId)) {
            return City::count();
        }
        return City::where('state_id', $statesId)->count();
    }
}
