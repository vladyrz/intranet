<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')
                ->badge($this->orderByStatus() ?? 0)
                ->badgeColor(Color::Orange)
                ->label(__('resources.employee.tab_total_employees')),
            Tab::make(__('resources.employee.tab_pending'))
                ->query(fn ($query) => $query->where('progress_status', 'pending'))
                ->badge($this->orderByStatus('pending') ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.employee.tab_in_form'))
                ->query(fn ($query) => $query->where('progress_status', 'in_form'))
                ->badge($this->orderByStatus('in_form') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.employee.tab_certified'))
                ->query(fn ($query) => $query->where('progress_status', 'certified'))
                ->badge($this->orderByStatus('certified') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.employee.tab_retired'))
                ->query(fn ($query) => $query->where('progress_status', 'retired'))
                ->badge($this->orderByStatus('retired') ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.employee.tab_referred'))
                ->query(fn ($query) => $query->where('progress_status', 'referred'))
                ->badge($this->orderByStatus('referred') ?? 0)
                ->badgeColor(Color::Fuchsia),
        ];
    }

    private function orderByStatus(string $status =null){
        if(blank($status)){
            return Employee::count();
        }
        return Employee::where('progress_status', $status)->count();
    }
}
